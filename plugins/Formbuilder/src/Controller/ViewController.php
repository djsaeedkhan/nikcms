<?php
namespace Formbuilder\Controller;
use Formbuilder\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Sms\Sms;

class ViewController extends AppController
{
    //----------------------------------------------------------------------
    public function initialize(){
        $this->loadComponent('Admin.Fileupload');
        $this->loadComponent('Captcha.Captcha'); //load on the fly!
        $this->ViewBuilder()->setLayout('Template.default');
        parent::initialize();
        $this->Auth->allow();
    }
    //----------------------------------------------------------------------
    public function index($id = null){
        $arr = [];
        if ($this->request->is('ajax')) {
            $this->render(false);
        }
        if ($id == null) {
            echo __d('Formbuilder', 'Ooops, Form Not Found');
            $this->render(false);
            return null;
        }

        $this->Formbuilders = TableRegistry::getTableLocator()->get('Formbuilder.Formbuilders');
        $result = null;
        if(is_numeric($id))
            $result = $this->Formbuilders->find('all')->contain(['FormbuilderItems'])->where(['id' => $id , 'enable' => 1])->first();
        else
            $result = $this->Formbuilders->find('all')->contain(['FormbuilderItems'])->where(['title' => $id, 'enable' => 1])->first();
        
        if (!$result) {
            echo __d('Formbuilder', 'Ooops, Form Not Founded.');
            $this->render(false);
            return null;
        }
        $result->counts = $result['counts'] + 1;
        $this->Formbuilders->save($result);
        $this->set('result', $result);
        $this->set('item', $items = $result->toarray()['formbuilder_items'][0]);

        // Save Data
        if ($this->request->is('post')) {
            if (!isset($this->request->getData()['securitycode']) or
                 $this->Captcha->getCode('securitycode') != $this->request->getData()['securitycode']) {
                $this->Flash->error(__d('Formbuilder', 'متاسفانه کد امنیتی وارد نشده است'));			
                return $this->redirect($this->referer());;
            }
            $form = preg_replace("/<div (.*?)>(.*?)<\/div>/", "$2", $items['data']);
            $form = preg_replace("/<div (.*?)>(.*?)<\/div>/", "$2", $form);
            preg_match_all('@data-title="(.*?)" data-name="([^"]+)" @', $form, $match );
            $input_list = [];
            if (isset($match[1]) and count($match[0])) {
                for ($i = 0; $i<count($match[0]); $i++) {
                    $input_list[$match[2][$i]] = $match[1][$i];
                }
            }

            $folder = 'formbuilder/'.$result->id.'/';
            $fuConfig['upload_path']    = WWW_ROOT .$folder;
            //$fuConfig['allowed_types']  = 'zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|jpg|jpeg|png';
            $fuConfig['allowed_types']  = 'zip|rar|pdf|jpg|jpeg';
            $fuConfig['max_size'] = 30000;
            if (!file_exists($fuConfig['upload_path'])) {
                mkdir($fuConfig['upload_path'], 0777, true);
            }
            
            foreach ($this->request->getData() as $name => $upload) {
                if (isset($upload['tmp_name'])) {
                    $fuConfig['file_name']  = 'form'.date('ymd-his').'-'.rand(10,9999999);
                    $this->Fileupload->init($fuConfig);
                    if (!$this->Fileupload->upload($name)) {
                        $fError = $this->Fileupload->errors();
                        if ($fError[0] == 'upload_invalid_filetype') {
                            $this->request = $this->request->withData($name, __d('Formbuilder', 'فایل اپلود نشد، پسوند فایل خطا دارد') );
                        } else {
                            $this->request = $this->request->withData($name, __d('Formbuilder', 'فایل اپلود نشد، پسوند فایل خطا دارد') );
                        }
                        //$this->Flash->error(__('متاسفانه اپلود فایل ضمیمه انجام نشد'));			
                    } else {
                        $this->request = $this->request->withData($name, Router::url('/', true).$folder.$this->Fileupload->output('file_name') );
                    }
                }
            }

            switch ($result['action']) {
                case 'all': 
                case 'db':
                    $this->FormbuilderDatas = TableRegistry::getTableLocator()->get('Formbuilder.FormbuilderDatas');
                    $temp = $this->FormbuilderDatas->newEntity();
                    $this->request = $this->request->withData('formbuilders_id', $result['id']);
                    
                    foreach($this->request->getData() as $k => $data)
                        $this->request = $this->request->withData($k, htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));

                    $this->request = $this->request->withData('data', serialize($this->request->getData()) );
                    $this->request = $this->request->withData('field', serialize($input_list));
                    $this->request = $this->request->withData('ips', $this->get_ip() );
                    $this->request = $this->request->withData('user_id', $this->Auth->user('id'));
                    $temp = $this->FormbuilderDatas->patchEntity($temp, $this->request->getData());
                    if ($this->FormbuilderDatas->save($temp)) {

                        $this->Func->create_admin_alert('formbuilder', [
                            'slug' => 'newform',
                            'title' => __d('Formbuilder', 'فرم جدید ثبت شد'),
                            'link' => '/admin/formbuilder/']);

                        if ($this->request->is('ajax')) {
                            $arr['message'] = __d('Formbuilder', 'اطلاعات با موفقیت دریافت شد.').__d('Formbuilder', 'کد پیگیری شما') .':' . $temp->id;
                            $arr['response'] = "success";
                        }else {
                            if (!$this->request->is('ajax'))
                                $this->Flash->success(
                                    __d('Formbuilder', 'اطلاعات با موفقیت دریافت شد.'). ' '. 
                                    __d('Formbuilder', 'کد پیگیری شما').' : '.$temp->id
                                );
                        }
                    } else {
                        if ($this->request->is('ajax')) {
                            $arr['message'] = __d('Formbuilder', 'متاسفانه ثبت اطلاعات فرم با موفقیت انجام نشد');
                            $arr['response'] = "error";
                        } else {
                            if(! $this->request->is('ajax'))
                                $this->Flash->error(__d('Formbuilder', 'متاسفانه ثبت اطلاعات فرم با موفقیت انجام نشد'));
                        }
                    }
                    break;
                case 'all': 
                case 'email':
                    $temp = $this->saveby_email($result, $input_list, $this->request->getData());
                    if ($this->request->is('ajax')) {
                        $arr['message'] = __d('Formbuilder', 'ثبت اطلاعات فرم با موفقیت انجام شد');
                        $arr['response'] = "success";
                    }
                    else
                        $this->Flash->success(__d('Formbuilder', 'ثبت اطلاعات فرم با موفقیت انجام شد'));

                    $this->Func->create_admin_alert('formbuilder', [
                        'slug' => 'newformemail',
                        'title' => __d('Formbuilder', 'فرم بصورت ثبت شده که بصورت ایمیل ارسال گردیده است'),
                        'link' => '/admin/formbuilder/']);
                    //$this->Flash->success(__('کد پیگیری شما : '.$temp->id));
                    break;
            }

            if($result['smstext'] != ''){
                $mobile = isset($input_list['mobile'])?$input_list['mobile']:null;
                if($mobile != null){
                    $sms = new Sms();
                    $sms->sendsingle([
                        'mobile' => $mobile,
                        'text' => $result['smstext'] ]);
                }
            }

            if($result['alert'] == 1){
                $this->alertby_email($result);
            }
            if($this->request->is('ajax')){
                $response = $this->response->withStringBody(json_encode($arr));
                return $response;
            }
            else
                $this->redirect($this->referer());
        }
    }
    //----------------------------------------------------------------------
    private function saveby_email($result = null, $input_list = null , $request = null){
        $str = null;
        foreach($request as $rk => $rv){
            $str .= (isset($input_list[$rk]) ? $input_list[$rk].':'. $rv: __d('Formbuilder', 'نامشخص').' : '.$rv);
            $str .='<br><br>';
        }
        return $this->send_email($result, $str);
    }
    //----------------------------------------------------------------------
    private function send_email($result = null , $message = null){
        if($result['emails'] == '') 
            return false;
        try {
            $email = new Email();
            $email->setTransport('default');
            $email
                ->setFrom([$result['emails'] => __d('Formbuilder', 'فرم ساز') ])
                ->setTo($result['emails'])
                ->setEmailFormat('html')
                ->setSubject(
                    __d('Formbuilder', 'فرم ساز').': '. 
                    (isset($result['title'])?$result['title']:'') )
                ->send($message);
        } catch (\Exception $e) {
            return false;
        }
        return true; 
    }
    //----------------------------------------------------------------------
    private function alertby_email($result = null){
        $this->send_email($result, __d('Formbuilder', 'یک فرم جدید در سیستم ثبت شد') );
    }
    //----------------------------------------------------------------------
    private function get_ip(){
        $ip = null;
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }
    //----------------------------------------------------------------------
    private function create_admin_alert($type = null){
        $p = $this->Func->OptionGet('alert_formbuilder');
        if($p == null){
            $temp[$type] = [
                'title'=>'1 '.__d('Formbuilder', 'فرم جدید ثبت شده است'),
                'count'=> 1,
                'link'=>'/admin/formbuilder/'
            ];
        }
        else{
            $temp = unserialize($p);
            if(isset($temp[$type]['count'])){
                $temp[$type] = [
                    'title'=>($temp[$type]['count']+1) .' '.__d('Formbuilder', 'فرم جدید ثبت شده است'),
                    'count'=> $temp[$type]['count']+1,
                    'link'=>'/admin/formbuilder/'
                ];
            }else{
                $temp[$type] = [
                    'title'=>'1 '. __d('Formbuilder', 'فرم جدید ثبت شده است'),
                    'count'=> 1,
                    'link'=>'/admin/formbuilder/'
                ];
            }
        }
        $this->Func->OptionSave('alert_formbuilder',serialize($temp),'create');
    }
}