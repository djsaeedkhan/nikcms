<?php
namespace Challenge\Controller;

use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Challenge\clsTbsZip;
use Challenge\Controller\AppController;
use Challenge\Export;
use Exception;
use PhpParser\Node\Stmt\Catch_;
use ZipArchive;

class ChallengeuserformsController extends AppController
{
    public function index($id = null){
        if($id != null){

            $cp = TableRegistry::getTableLocator()->get('Challenge.Users')->find('all')
               ->contain([
                    'Challengeqanswers'=>function ($q) use ($id) {
                        return $q->where([
                            'Challengeqanswers.challenge_id' => $id,
                        ]);
                    },
                    //'Challengeqanswers'=>['Challengequests'],
                    'Challengeuserforms'=>function ($q) use ($id) {
                        return $q->where([
                            'Challengeuserforms.challenge_id' => $id,
                        ]);
                    },
                ])
                ->toArray();

            $qlist = TableRegistry::getTableLocator()->get('Challenge.Challengequests')->find('list',['keyField' => 'id','valueField' => 'title'])
                ->where([ 'challenge_id'=> $id ])
                ->enablehydration(false)
                ->toarray();

            $challenge = TableRegistry::getTableLocator()->get('Challenge.Challenges')->find('all')
                ->where([ 'Challenges.id'=>$id])->first();
    
            $this->set([
                'cp'=>$cp,
                'challenge' => $challenge ,
                'qlist' => $qlist
            ]);
    
            //$this->set('challengeuserform', $challengeuserform);
            return $this->render('index2');
        }
        elseif(isset($this->request->getParam('?')['text']) and $this->request->getParam('?')['text']!=''){
            $search = $this->request->getParam('?')['text'];
            $temp =$this->Challengeuserforms->find('all')
                ->contain(['Challenges', 'Users'])
                ->where([ 'token1 LIKE '=>'%'.$search.'%']);

            if(! $temp->toArray()){
                $temp = $this->Challengeuserforms->find('all')
                    ->contain(['Challenges', 'Users'])
                    ->matching('Users', function ($q) use ($search) {
                        return $q->where([
                            'OR'=>[
                                'Users.family LIKE ' => '%'.$search.'%',
                                'Users.username LIKE ' => '%'.$search.'%',
                                'Users.phone LIKE' => '%'.$search.'%',
                                'Users.email LIKE' => '%'.$search.'%',
                            ],
                        ]);
                    });
            }
            if(! $temp->toArray()){
                $temp = $this->Challengeuserforms->find('all')
                    ->contain(['Challenges', 'Users'])
                    ->matching('Challenges', function ($q) use ($search) {
                        return $q->where([
                            'OR'=>[ 'Challenges.title LIKE ' => '%'.$search.'%' ]
                        ]);
                    });
            }
            $challengeuserforms = $this->paginate($temp);
        }
        else{
            $challengeuserforms = $this->paginate(
                $this->Challengeuserforms->find('all')
                    ->contain(['Challenges', 'Users'])
                    ->order(['id'=>'desc'])
            );
        }

        $this->set(compact('challengeuserforms'));

        //--------------------------------------------------------------------------------
        if ($this->request->is('post')){
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 500); 
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['getlist'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Challenges', 'Users'=>['UserMetas','Challengeuserprofiles']])
                ->toarray();

            $base_url = Router::url('/',true);
            $list =[];
            foreach($u as $us){ 
                
                $pdf = 'challenge/export/pdf/'.'ch'.$us['challenge']['id'].'_'.$us['user']['id'].'_'.'file.pdf';
                $word= 'challenge/export/word/'.'ch'.$us['challenge']['id'].'_'.$us['user']['id'].'_'.'file.docx';

                $metalist = [];
                if(isset($us['user']['user_metas']))
                    $metalist = $this->Func->MetaList($us['user'],'users');

                $temp = [
                    'id'=>$us->id,
                    'token1'=>$us->token1,
                    'family'=> isset($us['user']['family'])?$us['user']['family']:'',
                    'username'=> isset($us['user']['username'])?$us['user']['username']:'',
                    'mobile_profile'=> isset($us['user']['challengeuserprofiles'][0]['mobile'])?$us['user']['challengeuserprofiles'][0]['mobile']:'',
                    'mobile_register'=> isset($metalist['phone'])?$metalist['phone']:'',
                    'email_register'=> isset($us['user']['email'])?$us['user']['email']:'',
                    'email_profile'=> isset($us['user']['challengeuserprofiles'][0]['email'])?$us['user']['challengeuserprofiles'][0]['email']:'',
                    'challenge'=> isset($us['challenge']['title'])?trim($us['challenge']['title']):'',

                    //'title' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->title)))))),
                    //'descr1' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr1)))))),
                    //'descr2' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr2)))))),
                    //'descr3' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr3)))))),
                    //'descr4' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr4)))))),
                    //'descr5' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr5)))))),
                    //'descr6' => trim(preg_replace('/\s\s+/', ' ',(trim(preg_replace('/\t+/', '', h($us->descr6)))))),

                    'pdf' => $base_url.$pdf,
                    'word' => $base_url.$word,

                    'filesrc' => $us->filesrc,
                    'filesrc2' => $us->filesrc2,
                    'filesrc3' => $us->filesrc3,
                    'created'=>  $this->Query->the_time($us),
                ];
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list);
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['getmobile'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'=>['UserMetas','Challengeuserprofiles']])
                ->where(['challenge_id' => $this->request->getParam('?')['chid'] ])
                ->toarray();
            $list =[];
            foreach($u as $us){ 
                
                $metalist = [];
                if(isset($us['user']['user_metas']))
                    $metalist = $this->Func->MetaList($us['user'],'users');

                $temp = [
                    'mobile_profile'=> isset($us['user']['challengeuserprofiles'][0]['mobile'])?$us['user']['challengeuserprofiles'][0]['mobile']:'',
                    'mobile_register'=> isset($metalist['phone'])?$metalist['phone']:'',
                ];
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list,['لیست شماره']);
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['create_all_word'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'])
                ->toarray();
            $list =[];
            $count = 0;
            $export = new Export();

            foreach($u as $us){ 
                $name = WWW_ROOT.DS.'challenge'.DS.'export'.DS.'word'.DS.'ch'.$us->challenge_id.'_'.$us['user']['id'].'_'.'file.docx';
                if (! file_exists($name)) {
                    $p = $export->getword($us['id'],[
                        'id' => $us['user']['id'],
                        'username' => $us['user']['username'],
                        'family' => $us['user']['family'] ]);
                    if($p != '') $count+=1;
                }
            }
            $this->Flash->success('تعداد مشارکت ها: '.count($u)."<Br>".'تعداد فایل ایجاد شده: '.$count);
            $this->redirect($this->referer());
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['createword'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'])
                ->where(['challenge_id' => $this->request->getParam('?')['chid'] ])
                ->toarray();
            $list =[];
            $count = 0;
            $export = new Export();
            foreach($u as $us){ 
                $name = WWW_ROOT.DS.'challenge'.DS.'export'.DS.'word'.DS.'ch'.$us->challenge_id.'_'.$us['user']['id'].'_'.'file.docx';
                //if (! file_exists($name)) {
                    $p = $export->getword($us['id'],[
                        'id' => $us['user']['id'],
                        'username' => $us['user']['username'],
                        'family' => $us['user']['family'] ]);
                    if($p != '') $count+=1;
                //}
            }
            $this->Flash->success('تعداد مشارکت ها: '.count($u)."<Br>".'تعداد فایل ایجاد شده: '.$count);
            $this->redirect($this->referer());
        }
        //--------------------------------------------------------------------------------
        if ( $this->request->is('post') and isset($this->request->getParam('?')['createAllword']) ) {
            $challenge_id = $this->request->getParam('?')['chid'];
            $forms = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users','Challenges'])
                ->where(['challenge_id' => $challenge_id ])
                ->toarray();

            $zip = new clsTbsZip();
            $content = [] ;
            $r = '';
            $first = '';
            $j=0;
            foreach($forms as $i => $form){
                $url = 'challenge/export/word/ch'.$form['challenge_id'].'_'.$form['user_id'].'_file.docx';
                if (file_exists(WWW_ROOT . DS . $url)) {
                    
                    if($j == 0) $first = $url;
                    $p = $zip -> Open($url);
                    $content[$i] = $zip->FileRead('word/document.xml');
                    $zip->Close();// Extract the content of  document
                    
                    $p = strpos($content[$i], '<w:body');
                    if ($p===false)
                        echo ("Tag <w:body> not found in document .".$url);

                    $p = strpos($content[$i], '>', $p);
                    $content[$i] = substr($content[$i], $p+1);
                    $p = strpos($content[$i], '</w:body>');
                    if ($p===false)
                        echo ("Tag <w:body> not found in document .".$url );

                    $content[$i] = substr($content[$i], 0, $p);
                    $r .= $content[$i]  ;
                }
                $j+=1;
            }

            $zip->Open($first);
            $content2 = $zip->FileRead('word/document.xml');
            $p = strpos($content2, '</w:body>');
            if ($p===false)
                echo ("Tag <w:body> not found in document .".$first);

            $content2 = substr_replace($content2, $r, $p, 0);
            $zip->FileReplace('word/document.xml', $content2, TBSZIP_STRING);
            $zip->Flush(TBSZIP_FILE, 'word_merge_ch'.$challenge_id.'.docx');

            $this->redirect( Router::url('/',true).'/word_merge_ch'.$challenge_id.'.docx');
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['create_all_pdf'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'])
                //->where(['challenge_id' => $this->request->getParam('?')['chid'] ])
                ->toarray();

            $list =[];
            $count = 0;
            $export = new Export();
            foreach($u as $us){ 
                $name = WWW_ROOT.'challenge'.DS.'export'.DS.'pdf'.DS.'ch'.$us->challenge_id.'_'.$us['user']['id'].'_'.'file.pdf';
                if (! file_exists($name)) {
                    //echo("No exists ".$name).'<br>';
                    $p = $export->getpdf($us['id'],[
                        'id' => $us['user']['id'],
                        'username' => $us['user']['username'],
                        'family' => $us['user']['family'] ], 0); //0:no download
                    if($p != '')
                        $count+=1;
                }
                //else echo("exists ".$name).'<br>';
            }
            $this->Flash->success('تعداد مشارکت ها: '.count($u)."<Br>".'تعداد فایل ایجاد شده: '.$count);
            $this->redirect($this->referer());
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['createpdf'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'])
                ->where(['challenge_id' => $this->request->getParam('?')['chid'] ])
                ->toarray();
            $list =[];
            $count = 0;
            $export = new Export();
            foreach($u as $us){ 
                $name = WWW_ROOT.DS.'challenge'.DS.'export'.DS.'pdf'.DS.'ch'.$us->challenge_id.'_'.$us['user']['id'].'_'.'file.pdf';
                if (! file_exists($name)) {
                    $p = $export->getpdf($us['id'],[
                        'id' => $us['user']['id'],
                        'username' => $us['user']['username'],
                        'family' => $us['user']['family'] ], 0); //0:no download
                    if($p != '')
                        $count+=1;
                }
            }
            $this->Flash->success('تعداد مشارکت ها: '.count($u)."<Br>".'تعداد فایل ایجاد شده: '.$count);
            $this->redirect($this->referer());
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['zip'])) {
            set_time_limit(0);
            $export = new Export();
            if($this->request->getParam('?')['zip'] == 'word')
                $url = $export->getzip(['ext'=>'docx']);

            if($this->request->getParam('?')['zip'] == 'pdf')
                $url = $export->getzip(['ext'=>'pdf']);
            
            $this->redirect($url);
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['getemail'])) {
            $u = $this->Challengeuserforms->find('all')
                ->order(['Challengeuserforms.id' => 'desc'])
                ->contain(['Users'=>['UserMetas','Challengeuserprofiles']])
                ->where(['challenge_id' => $this->request->getParam('?')['chid'] ])
                ->toarray();
            $list =[];
            foreach($u as $us){ 
                $temp = [];
                $metalist = [];
                if(isset($us['user']['user_metas']))
                    $metalist = $this->Func->MetaList($us['user'],'users');

                $temp[] =  ($email = (isset($us['user']['email']) and $us['user']['email']!='')?$us['user']['email']:'');
                array_push( $list ,$temp );

                $temp = [];
                if(isset($us['user']['challengeuserprofiles'][0]['email']) and $us['user']['challengeuserprofiles'][0]['email']!= '' and $us['user']['challengeuserprofiles'][0]['email'] != $email){
                    $temp[] = $us['user']['challengeuserprofiles'][0]['email'];
                }
                array_push( $list ,$temp );
            }
            foreach($list as $k => $li){
                if(!count($li) or !strlen($li[0]) >= 3)
                unset($list[$k]);
            }
            $this->Func->tocsv( $list,['لیست ایمیل']);
        }
        //--------------------------------------------------------------------------------
        if ($this->request->is('post') and isset($this->request->getParam('?')['userforms'])) {
            $chlist = TableRegistry::getTableLocator()->get('Challenge.Challenges')
                ->find('list',['keyField' => 'id','valueField' => 'title'])
                ->toarray();
            $u = TableRegistry::getTableLocator()->get('Challenge.users')->find('all')
                ->contain(['Challengeuserforms' =>['Challenges']])
                ->toarray();
            $list =[];
            foreach($u as $us){ 
                $temp1 = [];
                foreach($us['challengeuserforms'] as $uss){
                    $temp1[$uss['challenge_id']] = $uss['challenge_id'];
                }
                $temp2 = [];
                foreach($chlist as $kch => $vch){
                    if(isset($temp1[$kch]))
                        $temp2[$kch] = 1 ;
                    else
                        $temp2[$kch] = '-' ;
                }
                $temp = [
                    'id'=>$us->id,
                    'family'=> isset($us['family'])?$us['family']:'',
                    'username'=> isset($us['username'])?strtolower($us['username']):'',
                ] + $temp2;
                array_push( $list ,$temp );
            }
            $this->Func->tocsv( $list,['id','family','username'] + $chlist);
        }
        //--------------------------------------------------------------------------------
    }
    public function view($id = null)
    {
        $challengeuserform = $this->Challengeuserforms->get($id, [
            'contain' => ['Challenges', 'Users'],
        ]);
        $this->Challengeqanswers = TableRegistry::getTableLocator()->get('Challenge.Challengeqanswers');
        $this->Challengequests = TableRegistry::getTableLocator()->get('Challenge.Challengequests');
        $chresult = $this->Challengeqanswers->find('all')
            ->where([
                'Challengeqanswers.challenge_id'=> $challengeuserform->challenge_id , 
                'user_id' => $challengeuserform->user_id ])
            ->order([ 'Challengeqanswers.id' =>'asc' ])
            ->contain(['Challengequests'])
            ->enablehydration(false)
            ->toarray();

        $qlist = $this->Challengequests->find('list',['keyField' => 'id','valueField' => 'title'])
            ->where([ 'challenge_id'=> $challengeuserform->challenge_id  ])
            ->enablehydration(false)
            ->toarray();

        $this->set([
            'chresult' => $chresult ,
            'qlist' => $qlist
            ]);


        $this->set('challengeuserform', $challengeuserform);
    }

    public function add()
    {
        $challengeuserform = $this->Challengeuserforms->newEmptyEntity();
        if ($this->request->is('post')) {
            $challengeuserform = $this->Challengeuserforms->patchEntity($challengeuserform, $this->request->getData());
            if ($this->Challengeuserforms->save($challengeuserform)) {
                $this->Flash->success(__('The challengeuserform has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeuserform could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeuserforms->Challenges->find('list', ['limit' => 200]);
        $users = $this->Challengeuserforms->Users->find('list', ['limit' => 200]);
        $this->set(compact('challengeuserform', 'challenges', 'users'));
    }

    public function edit($id = null)
    {
        $challengeuserform = $this->Challengeuserforms->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challengeuserform = $this->Challengeuserforms->patchEntity($challengeuserform, $this->request->getData());
            if ($this->Challengeuserforms->save($challengeuserform)) {
                $this->Flash->success(__('The challengeuserform has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challengeuserform could not be saved. Please, try again.'));
        }
        $challenges = $this->Challengeuserforms->Challenges->find('list', ['limit' => 200]);
        $users = $this->Challengeuserforms->Users->find('list', ['limit' => 200]);
        $this->set(compact('challengeuserform', 'challenges', 'users'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challengeuserform = $this->Challengeuserforms->get($id);
        if ($this->Challengeuserforms->delete($challengeuserform)) {
            $this->Flash->success(__('The challengeuserform has been deleted.'));
        } else {
            $this->Flash->error(__('The challengeuserform could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}