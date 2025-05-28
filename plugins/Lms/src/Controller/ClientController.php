<?php
namespace Lms\Controller;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Lms\Checker;
use Lms\Controller\AppController;
use Lms\Model\Entity\LmsCourse;
use Lms\VideoStream;
use Cake\Core\Configure;
use Cake\Event\Event as EventEvent;
use Cake\Log\Log;
use Cake\Routing\Router;
use DateTimeImmutable;
use Event;
use Lms\Video;
use SoapClient;

class ClientController extends AppController
{
    public function initialize() {
        parent::initialize();
        /* Configure::write('Session', [
            'defaults' => 'php',
            'ini' => [
                'session.cookie_lifetime' => 3600
            ]
        ]); */
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        ini_set('session.cookie_samesite', 'None');
        $this->setting =  unserialize($this->Func->OptionGet('plugin_lms'));
    }
    //----------------------------------------------------------
    public function video($id = null)
    {
        $this->autoRender = false;
        $id = explode(',',$id);
        Log::write('debug',$this->referer());
        if(isset($id[0]) and isset($id[1]) and $this->referer() == 'https://samaneh.tadabor.ir/lms/client/courses/36?file=292&show=1'){ //
            $src = $this->getTableLocator()->get('Lms.LmsCoursefiles')->find('all')->where(['id' => $id[0]])->first();
            if(isset($src['filesrc_'.$id[1]]) and $src['filesrc_'.$id[1]] != ''){
                $path = $src['filesrc_'.$id[1]];   
                $stream = new Video();
                $stream->start($path);
                //$path = str_replace('\/','/',$path);
                /* $filePointer = fopen($path, 'r');
                header('Content-Type: video/mp4');
                fpassthru($filePointer);  */
            }
        }
        else{
            echo "File Not Found";
        }
    }
    //----------------------------------------------------------------
    public function myexam()
    {
        $this->paginate = [
            'contain' => ['LmsExams','LmsCoursefiles'=>['LmsCourses','LmsCourseexams']],
            'order'=>['id'=>'desc'],
        ];

        $result = $this->LmsExamresults->find('all')->where(['LmsExamresults.user_id' => $this->request->getAttribute('identity')->get('id')]);

        if($this->request->getQuery('exam_id')){
            $result->where(['LmsExamresults.lms_exam_id' => $this->request->getQuery('exam_id')]) ;
            $result->order(['LmsExamresults.user_id' => 'desc']) ;
        }

        if($this->request->getQuery('user_id')){
            $result->where(['LmsExamresults.user_id' => $this->request->getQuery('user_id')]) ;
            $result->order(['LmsExamresults.lms_exam_id' => 'desc']) ;
        }

        $lmsExamresults = $this->paginate($result);
        $this->set(compact('lmsExamresults'));
    }
    //----------------------------------------------------------------
    public function certificate($id  = null)
    {
        $lmsCourseuser = $this->LmsCourseusers->find('all')
        ->where([
            'LmsCourseusers.lms_course_id'=>$id,
            'LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id')])
        ->contain(['lmsCourses'])
        ->first();
        if(! $lmsCourseuser){
            $this->Flash->error('دوره ای با این مشخصات پیدا نشد');
            return $this->redirect($this->referer());
        }
        $lmsCourses  = $lmsCourseuser['LmsCourses'];

        if($lmsCourseuser['enable'] == 1){
            $this->Flash->error('دوره شما هنوز به پایان نرسیده است. 
            پس از پایان دوره امکان درخواست گواهینامه وجود دارد');
            return $this->redirect($this->referer());
        }

        $this->LmsCertificates = TableRegistry::getTableLocator()->get('Lms.LmsCertificates');

        $history = $this->LmsCertificates->find('all')
            ->where([
                'user_id'=> $this->request->getAttribute('identity')->get('id'),
                'lms_course_id' => $id
            ])
            ->toarray();

        $lmsCertificate = $this->LmsCertificates->newEmptyEntity(();
        if ($this->request->is('post')) {
            $this->request = $this->request->withData('lms_course_id', $id);
            $this->request = $this->request->withData('user_id', $this->request->getAttribute('identity')->get('id'));
            $this->request = $this->request->withData('input_data', json_encode($this->request->getData()['data']));

            $lmsCertificate = $this->LmsCertificates->patchEntity($lmsCertificate, $this->request->getData());
            if ($this->LmsCertificates->save($lmsCertificate)) {
                $this->Flash->success(__('ثبت درخواست گواهینامه با موفقیت انجام شد'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('متاسفانه ثبت درخواست گواهینامه انجام نشد'));
        }

        $this->set(compact('lmsCertificate', 'lmsCourses','history'));

    }
    //----------------------------------------------------------------
    public function index()
    {
        /* $this->autoRender = false;
        $stream = new VideoStream("26-shahr.mp4");
        $stream->start();
        exit(); */

        $lmsCourses = $this->LmsCourseusers->find('all')
            ->where(['LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['lmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles']]])
            ->order(['LmsCourseusers.id'=>'desc'])
            ->toarray();

        $lmsCoursefiles = [];
        $lmsCoursefilecan = [];
        $lmsCourseexam = [];

        foreach($lmsCourses as $lms){ 
            $lms_id = $lms['LmsCourses']['id'];
            $lmsCoursefiles[  $lms_id ] =  $this->LmsCoursefiles
                ->find('list',['keyField' => 'id','valueField' => 'id'])
                ->where(['lms_course_id'=>  $lms_id ])
                ->toarray();

            if(count($lmsCoursefiles[  $lms_id ])){
                $query = $this->LmsCoursefilecans
                    ->find('list',['keyField' => 'lms_coursefile_id','valueField' => 'count'])
                    ->select(['lms_coursefile_id','user_id'])
                    ->where(['user_id'=> $this->request->getAttribute('identity')->get('id') , 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                    ->group(['lms_coursefile_id']);
                $lmsCoursefilecan[  $lms_id ] =  $query->select(['count' => $query->func()->count('lms_coursefile_id') ])->toarray();

                $lmsCourseexam[  $lms_id ]  = $this->LmsCourseexams
                    ->find('list',['keyField' => 'id','valueField' => 'id'])
                    ->where([ 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                    ->toarray();
            }
        }
        $this->set([
            'lmsCourses' => $lmsCourses,
            'lmsCoursefilecan' => $lmsCoursefilecan,
            'lmsCoursefiles'=> $lmsCoursefiles,
            'lmsCourseexam' => $lmsCourseexam,
        ]);
    }
    //----------------------------------------------------------------
    private function renew($id  = null, $month = null)
    {
        $checker = new Checker();
        $options = null;
        $lmsCourseuser = $this->LmsCourseusers->find('all')
            ->where([
                'LmsCourseusers.lms_course_id'=>$id,
                'LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['lmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles']]])
            ->first();
        if(! $lmsCourseuser){
            $this->Flash->error('دوره ای با این مشخصات پیدا نشد');
            return $this->redirect($this->referer());
        }
        $lmsCourses = $lmsCourseuser['LmsCourses'];
        $expire = $checker->CheckUsercourseExpire($lmsCourses,$lmsCourseuser); 
        if($expire === false){

            if($lmsCourses['can_renew'] != 1){
                $this->Flash->error('در حال حاضر امکان تمدید در این دوره امکان پذیر نمی باشد.');
                return $this->redirect($this->referer());
            }

            if($this->LmsUserfactors->find('all')
                ->where([
                    'user_id'=>$this->request->getAttribute('identity')->get('id'),
                    'lms_course_id'=>$lmsCourses['id'],
                    'enable'=>0,
                ])
                ->count() > 0 )
            {
                $this->Flash->error('برای این دوره فاکتور پرداخت نشده ثبت شده است.<br>
                لطفا نسبت به پرداخت آن از طریق <b>پنل کاربری » فاکتورها</b> اقدام نمایید.');
                return $this->redirect($this->referer());
            }

            if($month != null){
                
                $course_option = [];
                if($lmsCourses['options'] != ""){
                    $course_option = json_decode($lmsCourses['options'],true);
                }

                if(
                    isset($course_option['renew'][$month.'m_title']) and 
                    $course_option['renew'][$month.'m_title'] != "" and
                    isset($course_option['renew'][$month.'m_price']) and
                    $course_option['renew'][$month.'m_price'] != "" and 
                    intval($course_option['renew'][$month.'m_price']) > 0
                ){
                    $lmsCourses['price_renew'] = intval($course_option['renew'][$month.'m_price']);
                    $lmsCourses['renew_day'] = $course_option['renew'][$month.'m_title'];

                    $options = [
                        'price_renew' => $lmsCourses['price_renew'],
                        'renew_day' => $course_option['renew'][$month.'m_day'],
                        'renew_title' => $lmsCourses['renew_day'],
                    ];
                }
                else{
                    $this->Flash->error('تاریخ / مبلغ صحیح برای تمدید این دوره پیدا نشد');
                    return $this->redirect($this->referer());  
                }
            }

            $lmsFactor = $this->LmsFactors->newEmptyEntity(();
            $lmsFactor = $this->LmsFactors->patchEntity($lmsFactor,[
                    'user_id'=>$this->request->getAttribute('identity')->get('id'),
                    'price'=>$lmsCourses['price_renew'],
                    'paid'=>0,
                    'status'=>0,
                    'options' => $options!= null?json_encode($options):false,
                    'descr'=>'تمدید دوره "'. $lmsCourses['title'].'" به مدت '.$lmsCourses['renew_day'] ,
                ]);
            if ($id = $this->LmsFactors->save($lmsFactor)) {
                $lmsuserf = $this->LmsUserfactors->newEmptyEntity(();
                $lmsuserf = $this->LmsUserfactors->patchEntity($lmsuserf,[
                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                        'lms_factor_id' => $lmsFactor->id,
                        'lms_course_id' => $lmsCourses['id'],
                        'enable' => 0,
                    ]);
                if ($this->LmsUserfactors->save($lmsuserf)) {
                    $this->Flash->success('
                        ثبت فاکتور شماره #'.$lmsFactor->id.' با موفقیت انجام شد. '.
                        '<br>جهت فعال شدن دوره، از طریق دکمه زیر، اقدام به پرداخت فاکتور نمایید.'
                    );
                    return $this->redirect('/lms/client/factors?id='.$lmsFactor->id);
                }
                else{
                    $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد92 ');
                    return $this->redirect($this->referer());
                }
            }else{
                $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد91 ');
                return $this->redirect($this->referer());
            }
        }
        else{
            $this->Flash->error('متاسفانه هنوز به زمان تمدید دوره شما نرسیده ایم');
            $this->redirect($this->referer());
        }
    }
    //----------------------------------------------------------------
    private function renewExam($course_id  = null, $exam_id = null)
    {
        $checker = new Checker();
        $options = null;
        $lmsCourseuser = $this->LmsCourseusers->find('all')
            ->where([
                'LmsCourseusers.lms_course_id'=> $course_id,
                'LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['lmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles']]])
            ->first();
        if(! $lmsCourseuser){
            $this->Flash->error('دوره ای با این مشخصات پیدا نشد');
            return $this->redirect($this->referer());
        }

        $lmsExam = $this->LmsExams->find('all')
            ->where([ 'LmsExams.id'=> $exam_id ])
            ->first();
        if(! $lmsExam){
            $this->Flash->error('آزمونی با این مشخصات پیدا نشد');
            return $this->redirect($this->referer());
        }

        $lmsCourses = $lmsCourseuser['LmsCourses'];
        $expire = $checker->CheckUsercourseExpire($lmsCourses,$lmsCourseuser); 
        if($expire === true){
            $this->Flash->error('دوره شما منقضی شده و امکان انجام این درخواست نمی باشد');
            $this->redirect($this->referer());
        }

        if($this->LmsUserfactors->find('all')
            ->where([
                'user_id'=>$this->request->getAttribute('identity')->get('id'),
                'lms_course_id'=>$lmsCourses['id'],
                'lms_exam_id'=>$exam_id,
                'enable'=> 0, //استفاده نشده
            ])
            ->count() > 0 )
        {
            $this->Flash->error('برای این آزمون، فاکتور پرداخت نشده ثبت شده است.<br>
            لطفا نسبت به پرداخت آن از طریق <b>پنل کاربری » فاکتورها</b> اقدام نمایید.');
            return $this->redirect($this->referer());
        }


        $exam_option = $options = [];
        if($lmsExam['options'] != ""){
            $exam_option = json_decode($lmsExam['options'],true);
        }

        $again = $this->LmsUserfactors->find('all')
            ->where([
                'user_id'=>$this->request->getAttribute('identity')->get('id'),
                'lms_course_id'=>$lmsCourses['id'],
                'lms_exam_id'=>$exam_id,
                'enable'=>1,
            ])->count() + 1;

        if(
            isset($exam_option['again'][$again.'m_title']) and 
            $exam_option['again'][$again.'m_title'] != "" and
            isset($exam_option['again'][$again.'m_price']) and
            $exam_option['again'][$again.'m_price'] != "" and 
            intval($exam_option['again'][$again.'m_price']) > 0
        ){
            
            $options = [
                'renew_price' => $exam_option['again'][$again.'m_price'],
                'renew_title' => $exam_option['again'][$again.'m_title'],
            ];
        }
        else{
            $this->Flash->error('تاریخ / مبلغ صحیح برای تمدید آزمون پیدا نشد');
            return $this->redirect($this->referer());  
        }

        $lmsFactor = $this->LmsFactors->newEmptyEntity(();
        $lmsFactor = $this->LmsFactors->patchEntity($lmsFactor,[
                'user_id'=>$this->request->getAttribute('identity')->get('id'),
                'price'=> $options['renew_price'],
                'paid'=>0,
                'status'=>0,
                'options' => $options!= null?json_encode($options):false,
                'descr'=>'انجام مجدد آزمون "'. $lmsExam['title'].'" / '.$options['renew_title'] ,
            ]);

        if ($id = $this->LmsFactors->save($lmsFactor)) {
            $lmsuserf = $this->LmsUserfactors->newEmptyEntity(();
            $lmsuserf = $this->LmsUserfactors->patchEntity($lmsuserf,[
                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                    'lms_factor_id' => $lmsFactor->id,
                    'lms_course_id' => $lmsCourses['id'],
                    'lms_exam_id' => $lmsExam['id'],
                    'enable' => 0, //0: استفاده نشده
                ]);
            if ($this->LmsUserfactors->save($lmsuserf)) {
                $this->Flash->success('
                    ثبت فاکتور شماره #'.$lmsFactor->id.' با موفقیت انجام شد. '.
                    '<br>جهت فعال شدن آزمون، از طریق دکمه زیر، اقدام به پرداخت فاکتور نمایید.'
                );
                return $this->redirect('/lms/client/factors?id='.$lmsFactor->id);
            }
            else{
                $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد92 ');
                return $this->redirect($this->referer());
            }
        }else{
            $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد91 ');
            return $this->redirect($this->referer());
        }
    }
    //----------------------------------------------------------------
    public function course($id  = null, $data = null) //list of all user course
    {
        if(isset($this->request->getParam('?')['do']) and $this->request->getParam('?')['do'] == 'renew'){
            return $this->renew($id , $data);
        }

        if(isset($this->request->getParam('?')['do']) and $this->request->getParam('?')['do'] == 'renewExam'){
            return $this->renewExam($id , $data);
        }

        $lmsCourses = $this->LmsCourseusers->find('all')
            ->where(['LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['lmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles']]])
            ->order(['LmsCourseusers.id'=>'desc'])
            ->toarray();

        $lmsCoursefiles = [];
        $lmsCoursefilecan = [];
        $lmsCourseexam = [];

        foreach($lmsCourses as $lms){ 
            $lms_id = $lms['LmsCourses']['id'];
            $lmsCoursefiles[  $lms_id ] =  $this->LmsCoursefiles
                ->find('list',['keyField' => 'id','valueField' => 'id'])
                ->where(['lms_course_id'=>  $lms_id ])
                ->toarray();

            if(count($lmsCoursefiles[  $lms_id ])){
                $query = $this->LmsCoursefilecans
                    ->find('list',['keyField' => 'lms_coursefile_id','valueField' => 'count'])
                    ->select(['lms_coursefile_id','user_id'])
                    ->where(['user_id'=> $this->request->getAttribute('identity')->get('id') , 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                    ->group(['lms_coursefile_id']);
                $lmsCoursefilecan[  $lms_id ] =  $query->select(['count' => $query->func()->count('lms_coursefile_id') ])->toarray();

                $lmsCourseexam[  $lms_id ]  = $this->LmsCourseexams
                    ->find('list',['keyField' => 'id','valueField' => 'id'])
                    ->where([ 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                    ->toarray();
            }
        }
        $this->set([
            'lmsCourses' => $lmsCourses,
            'lmsCoursefilecan' => $lmsCoursefilecan,
            'lmsCoursefiles'=> $lmsCoursefiles,
            'lmsCourseexam' => $lmsCourseexam,
        ]);
    }
    //----------------------------------------------------------------
    public function courses($id = null , $file = null)
    {
        $checks = new Checker();

        $lmsCourses = $this->LmsCourseusers->find('all')
            ->where(['LmsCourseusers.user_id'=> $this->request->getAttribute('identity')->get('id') , 'lms_course_id' =>$id ] )
            ->contain(['LmsCourses'])
            ->first();

        if(! $lmsCourses){
            $this->Flash->error('شما به این دوره دسترسی ندارید');
            $this->redirect($this->referer());
        }

        $results = $this->LmsCourses->find('all')
            ->contain(['LmsCourseweeks'=> [
                'sort' => ['LmsCourseweeks.priority'=>'ASC'],
                'lmsCoursefiles'=>['lmsCoursefilenotes','LmsCourseexams'=>'LmsExams'] ]
            ])
            ->where(['id' => $id ])
            ->first();

        $factor = $this->LmsUserfactors->find('all')
            ->where([
                'enable'=>0,
                'LmsUserfactors.lms_exam_id IS NULL',
                'LmsUserfactors.user_id'=> $this->request->getAttribute('identity')->get('id') , 
                'lms_course_id' =>$id ] )
            ->contain(['LmsFactors'])
            ->first();
        if($factor){
            $this->set([
                'results' => $results,
                'factor'=> $factor ]);
            return $this->render('course_denied');
        }

        //----------------------------------------------------------------
        if($lmsCourses['enable'] != 1){ //وقتی کاربر یکبار دوره را سپری میکند، مقدار فعال: یک می شود
            if($lmsCourses['lms_course']['date_type'] == 2){ //تاریخ شروع مشخص شده برای دوره
                $time = new Time( $lmsCourses['lms_course']['date_start'] );
            }
            else{//تاریخ ثبت دوره برای کاربر
                $time = new Time( $lmsCourses['created']);
            }
            $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
            if(Time::now() < $time){
                $this->Flash->success('زمان شرکت در این دوره فرا نرسیده است. لطفا تا تاریخ شروع دوره صبر کنید');
                return $this->redirect($this->referer());
            }
            //----------------------------------------------------------------

            if( $lmsCourses['lms_course']['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
                $time = new Time( $lmsCourses['lms_course']['date_end']->format('Y-m-d') );
            }
            else{ //تاریخ ثبت دوره برای کاربر
                //https://www.php.net/manual/en/dateinterval.format.php
                $interval = date_diff(
                    date_create($lmsCourses['lms_course']['date_start']->format('Y-m-d')),
                    date_create($lmsCourses['lms_course']['date_end']->format('Y-m-d')) );
                $origin = $interval->format('%R%a');
                $day = (intval($origin));

                $time = new Time($lmsCourses['created']);
                if($day > 0){
                    $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    $time->addDays($day);
                }
                $time = $time->format('Y-m-d');
            }
            if( Time::now()->format('Y-m-d') > $time){
                $this->Flash->success('مدت زمان دسترسی شما به این دوره به پایان رسیده است. می توانید با استفاده از دکمه «تمدید دوره» دسترسی به دروس دوره را تمدید نمایید.');
                return $this->redirect($this->referer());
            }
        }
        
        //----------------------------------------------------------------

        $file_id = null;
        $pp = $this->LmsCoursefiles->find('list',['keyField'=>'id'])
            ->where(['LmsCoursefiles.lms_course_id' => $id ])
            ->contain(['LmsCourseweeks'])
            ->order(['LmsCoursefiles.priority'=>'ASC' ])
            ->toarray(); //لیست فایل ها
        $tt = $this->LmsCoursefilecans->find('all')
            ->where(['user_id' => $this->request->getAttribute('identity')->get('id') , 'lms_coursefile_id IN'=> $pp ])
            ->count();
        $pp = array_values($pp);
        if($tt == 0 and isset($pp[0])){
           $checks->enablefile($this->request->getAttribute('identity')->get('id') ,$pp[0] );
        }

        if($this->request->getQuery('qty') ){
            $this->set([
                'qty' => $this->request->getQuery('qty')
            ]);
        }

        //--------------------------------
        $file_id = $this->request->getQuery('file');
        $file = $this->LmsCoursefiles->find('all')
            ->contain([
                'lmsCoursefilenotes',
                'LmsCourseexams'=>'LmsExams',
                'LmsCourseweeks'])
            ->where([ 'LmsCoursefiles.id' => $file_id ])
            ->enablehydration(false)
            ->first();
        $show_current = false;
        if($lmsCourses['enable'] == 1){ //وقتی کاربر یکبار دوره را سپری میکند، مقدار فعال: یک می شود
            $show_current = true;
        }
        elseif($checks->checkIS($id,$file_id , $this->request->getAttribute('identity')->get('id'),  $this->request->getQuery() )){
            $show_current = true;
        }
        $this->set(['show_current' => $show_current]);
        //--------------------------------

        if($this->request->is('ajax') and $this->request->is('post')) {
            $this->autoRender = false;

            if($this->request->getQuery('visit') and $this->request->getQuery('visit')!='' ){
                $sessions = $this->LmsCoursesessions->patchEntity($this->LmsCoursesessions->newEmptyEntity((), [
                    'lms_course_id' => $id,
                    'lms_coursefile_id' => $file_id ,
                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                ]);
                $this->LmsCoursesessions->save($sessions);
                return $this->response->withStringBody("success-01");
            }

            $file_id = $this->request->getQuery('file');
            $next = $checks->find_next($file_id );
            $response = $this->response->withStringBody('empty');
            if($next != null){
                $file_exam = $this->LmsCourseexams->find('all')
                    ->where(['lms_coursefile_id' => $file_id ])
                    ->first();
                if(! $file_exam){
                    $p = $checks->enablefile($this->request->getAttribute('identity')->get('id') ,$next);
                    if($p == 1)
                        $response = $this->response->withStringBody(Router::url([$id ,'?'=>['file'=> $next ]],true));
                    else
                        $response = $this->response->withStringBody($p);
                }
            }else{

                //در صورتی که فایل بعدی وجود نداشت یعنی آخرین فایل می باشد
                $this->LmsCourseusers->query()->update()
                    ->set([
                        'enable' => 0,
                        'status'=> 1 ])
                    ->where([
                        'user_id' => $this->request->getAttribute('identity')->get('id') ,
                        'lms_course_id'=>$id
                        ])
                    ->execute();
                $response = $this->response->withStringBody("finished");
            }
            return $response;
        }
        $this->set([
            'results' => $results,
            'page' => $this->request->getQuery('file') ?$this->request->getQuery('file') :0 ,
            'file' => $file,
            'file_id'=> $file_id ]);
        $this->render('course_index');
    }
    //----------------------------------------------------------------
    public function exam($id = null)
    {
        $file = $this->LmsCourseexams->find('all')
            ->contain([ 'lmsExams'=>[
                'LmsExamquests'=>['sort' => ['LmsExamquests.priority'=>'ASC']]
                ]])
            ->where([ 'LmsCourseexams.id' => $id ])
            ->enableAutoFields(true)
            ->first();
        if(! $file ){
            $this->Flash->error('چنین آزمونی پیدا نشد');
            return $this->redirect($this->referer());
        } 

        $examquests = $this->LmsExamquests->find('list',['keyField'=>'id','valueField'=>'correct'])
            ->where(['lms_exam_id' => $file['lms_exam_id'] ])
            ->order(['LmsExamquests.priority'])
            ->toarray();

        $course_id = $this->LmsCoursefiles->find('all')
            ->where(['id' => $file['lms_coursefile_id']])->first()['lms_course_id'];

        $this->set([
            'course_id' => $course_id,
            'results' => $file,
            'questions' => $file,

            'exampay' => $exampay = $this->LmsUserfactors->find('all')
                ->contain(['LmsFactors'])
                ->where([
                    'LmsFactors.paid'=>1,
                    'LmsUserfactors.user_id'=> $this->request->getAttribute('identity')->get('id'),
                    'LmsUserfactors.lms_exam_id'=> $file['lms_exam_id'],
                    'LmsUserfactors.enable'=> 0 // استفاده نشده
                    ])
                ->count(),

            'exampaylist' => $exampaylist = $this->LmsUserfactors->find('all')
                ->contain(['LmsFactors'])
                ->where([
                    'LmsFactors.paid'=>1,
                    'LmsUserfactors.user_id'=> $this->request->getAttribute('identity')->get('id'),
                    'LmsUserfactors.lms_exam_id'=> $file['lms_exam_id'],
                    ])
                ->count(),
        ]);    
        //------------------------------------------------------------------
        
        if($this->request->is('post')) {

            $temp = $this->LmsExamresults->find('all')
                ->where([
                    'user_id' => $this->request->getAttribute('identity')->get('id') , 
                    'token' => $this->request->getQuery('starts') , 
                    'result' => 0])
                ->first();
            if(!$temp){
                $this->Flash->success('آزمون پایان یافته است');
                return $this->redirect($this->referer());
            }
            $time = new Time($temp['created']);
            $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
            $time->addMinutes($file['LmsExams']['timer']);
            $timer = $time->format('Y-m-d H:i:s');
            
            if(Time::now() > $time){
                $this->Flash->success('مدت زمان پاسخگویی به این آزمون به پایان رسیده است. اطلاعات فرم ثبت نشد');
                return $this->redirect('?');
            }

            $lms_examresult_id = null;
            if($this->request->getQuery('starts')){
                $lmsresult =  $this->LmsExamresults->find('all')
                    ->where([
                        'token' => $this->request->getQuery('starts') ,
                        'result' => 0,
                        'user_id' => $this->request->getAttribute('identity')->get('id') ])
                    ->first();
                if($lmsresult)
                    $lms_examresult_id = $lmsresult->id;
            }

            if($lms_examresult_id == null) 
                return $this->redirect('/');
            
            $fail_count = 0;

            $tashrihi = false;
            $quest_type = $this->LmsExamquests->find('list',['keyField'=>'id','valueField'=>'types'])
                ->where(['lms_exam_id' => $file['lms_exam_id'] ])
                ->toarray();

            foreach($this->request->getData()['q'] as $k => $qs){

                if(isset($quest_type[$k]) and $quest_type[$k] ==1){
                    $fail = 1;
                    if(isset($examquests[$k]) and $examquests[$k]!= 0 and $examquests[$k] != $qs){
                        $fail_count += 1;
                        $fail = 0;
                    }
                }elseif(isset($quest_type[$k]) and $quest_type[$k] == 0){
                    $tashrihi = true;
                    $fail = 2;
                }
                
                $lmsExamresult = $this->LmsExamresultlists->newEmptyEntity(();
                $lmsExamresult = $this->LmsExamresultlists->patchEntity($lmsExamresult,[
                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                    'lms_examresult_id'=> $lms_examresult_id ,
                    'lms_exam_id' => $file['lms_exam_id'] ,
                    'lms_examquest_id' => $k ,
                    'answer' => "$qs",
                    'result' => $fail ]);
                $p = $this->LmsExamresultlists->save($lmsExamresult);
            }
            
            $fail = (($fail_count > $file['LmsExams']['fail_count'])?1:2);
            if($tashrihi == true){
                $fail = 3;
            }

            $this->LmsExamresults->query()->update()
                ->set(['result' => $fail ])
                ->where(['id' => $lmsresult->id])
                ->execute();

            if($fail == 3){
                $this->Flash->success('نتیجه این آزمون پس از تصحیح و بررسی اعلام خواهد گردید');
            }
            elseif($fail == 2){
                $checks = new Checker();
                $next = $checks->find_next($file['lms_coursefile_id'] );
                if($next != null){ //اگر فایل بعدی وجود داشت
                    if($checks->enablefile($this->request->getAttribute('identity')->get('id'), $next ) != 1)
                        $this->Flash->success('سطح بعدی دوره برای شما فعال گردید');
                }
                else{
                    //در صورتی که فایل بعدی وجود نداشت یعنی آخرین فایل می باشد
                    $this->LmsCourseusers->query()->update()
                    ->set([
                        'enable' => 0,
                        'status'=> 1 ])
                    ->where([
                        'user_id' => $this->request->getAttribute('identity')->get('id') ,
                        'lms_course_id'=>$course_id
                        ])
                    ->execute();
                }
                $this->Flash->success('شما در آزمون قبول شدید');
            }
            else{
                $this->Flash->error('شما در آزمون مردود شدید');
            }

            //
            $this->LmsUserfactors->query()->update()
                ->set([
                    'enable'=> 1,
                    //0: استفاده نشده
                ])
                ->where([
                    'LmsUserfactors.lms_exam_id'=> $file['lms_exam_id'],
                    'LmsUserfactors.user_id'=> $this->request->getAttribute('identity')->get('id'),
                ])
                ->execute();
           
            return $this->redirect('?result='.$lmsresult->token);
        }
        //------------------------------------------------------------------
        if($this->request->getQuery('start')){
            $temp = $this->LmsExamresults->find('all')
                ->where([
                    'user_id' => $this->request->getAttribute('identity')->get('id') ,
                    'lms_coursefile_id' => $file['lms_coursefile_id'],
                    'lms_exam_id' => $file['lms_exam_id'] , //'result !=' => 0
                    ])
                ->toarray();

            if($exampay != 0 and count($temp) >= $file['LmsExams']['reexam'] + $exampaylist + $exampay ){
                $this->Flash->error('امکان شرکت در آزمون برای شما فعال نیست');
                return $this->redirect($this->referer());
            }

            $tempr = $this->history( $file['lms_coursefile_id'] , $file['lms_exam_id']);
            foreach($tempr as $cnt){
                if($cnt['result'] == 2) {
                    $this->Flash->error('شما قبلا در این آزمون شرکت کرده و قبول شده اید.<br><b>
                            امکان شروع دوباره آزمون قبول شده وجود ندارد</b>');
                    return $this->redirect($this->referer());
                }
            }
            
            $lmsExamresult = $this->LmsExamresults->newEmptyEntity(();
            $lmsExamresult = $this->LmsExamresults->patchEntity($lmsExamresult,[
                'user_id'=> $this->request->getAttribute('identity')->get('id'),
                'lms_exam_id'=> $file['lms_exam_id'],
                'lms_coursefile_id' => $file['lms_coursefile_id'] , 
                'token'=> $this->request->getAttribute('identity')->get('id').$id.rand(100,9999),
            ]);
            if(! ($p = $this->LmsExamresults->save($lmsExamresult))){
                $this->Flash->error('لطفا دوباره تلاش کنید');
                return $this->redirect($this->referer());
            }
            else{
                $this->Flash->success('آزمون با موفقیت شروع شد');
                return $this->redirect('?starts='.$p['token']);
            }
        }
        //------------------------------------------------------------------
        elseif($this->request->getQuery('starts')){
            $temp = $this->LmsExamresults->find('all')
                ->where([
                    'user_id' => $this->request->getAttribute('identity')->get('id') , 
                    'token' => $this->request->getQuery('starts') , 
                    'result' => 0])
                ->first();
            if(!$temp){
                $this->Flash->success('آزمون پایان یافته است');
                return $this->redirect($this->referer());
            }

            $time = new Time($temp['created']);
            $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
            $time->addMinutes($file['LmsExams']['timer']);
            $timer = $time->format('Y-m-d H:i:s');
            if(Time::now() > $time){
                $this->Flash->success('مدت زمان پاسخگویی به این آزمون به پایان رسیده است');
                return $this->redirect('?');
            }

            $this->set([
                'time' => $timer,
                'temp'=> $temp
            ]);
            $this->render('exam_start');
        }
        //------------------------------------------------------------------
        elseif($this->request->getQuery('result')){

            $lms_examresult_id = null;
            if($this->request->getQuery('result')){
                $lmsresult =  $this->LmsExamresults->find('all')
                    ->where([
                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                        'result != ' => 0,
                        'token' => $this->request->getQuery('result') ])
                    ->first();
                if($lmsresult)
                    $lms_examresult_id = $lmsresult->id;
            }
            if($lms_examresult_id == null){
                $this->Flash->success('آزمون پیدا نشد');
                return $this->redirect($this->referer());
            }

            $final = $this->LmsExamresultlists->find('list',['keyField'=>'lms_examquest_id','valueField'=>'answer'])
                    ->where(['lms_examresult_id' => $lms_examresult_id, 'user_id'=>$this->request->getAttribute('identity')->get('id') ])
                    ->toarray();

            if(!$final){
                $this->Flash->success('آزمون پیدا نشد');
                return $this->redirect($this->referer());
            }

            $this->set([
                'history' => $this->history( $file['lms_coursefile_id'] , $file['lms_exam_id']),
                'final' => $final,
                'examres'=> $lmsresult,
                'exam_result' => $lmsresult['result'],
                ]);

            $lmsExamresult = $this->LmsExamresults->find('all')
                ->contain(['Users', 'LmsExams','LmsCoursefiles'=>['LmsCourses'], 'LmsExamresultlists'=>['LmsExamquests']])
                ->where(['LmsExamresults.token' => $this->request->getQuery('result')])
                ->first();
            $this->set('lmsExamresult', $lmsExamresult);
            $this->render('exam_result');
        }
        //------------------------------------------------------------------
        else{
            $this->set([
                'history' => $this->history( $file['lms_coursefile_id'] , $file['lms_exam_id'])
            ]);
            $this->render('exam');

        }
    }
    //----------------------------------------------------------------
    private function history($coursefile_id = null , $exam_id = null)
    {
        return $this->LmsExamresults->find('all')
            ->contain(['LmsExamresultlists'])
            ->order(['id'=> 'desc'])
            ->where([
                'user_id' => $this->request->getAttribute('identity')->get('id') , 
                'lms_coursefile_id' => $coursefile_id,
                'lms_exam_id' => $exam_id ])
            ->toarray();
    }
    //----------------------------------------------------------------
    private function _Coupons_Check($factors = null, $data = null)
    {
        if(count($factors)> 1){
            return [
                'status' => false,
                'error' => "در حال حاضر امکان اعمال کد تخفیف نمی باشد"
            ];
        }
        
        if( $factors[0]['lms_coupon_id'] != ""){
            return [
                'status' => false,
                'error' => "برای این فاکتور قبلا کد تخفیف ثبت شده است."
            ];
        }

        $coupons = $this->LmsCoupons->find('all')
            ->where(['title'=> $data['coupons']])
            ->contain(["LmsFactors" => [
                'queryBuilder' => function ($q) {
                    return $q->where(['LmsFactors.paid'=>'1']);
                }
            ]])
            ->first();
        if(!$coupons ){
            return [
                'status' => false,
                'error' => "چنین کد تخفیفی پیدا نشد / تعداد مجاز استفاده به پایان رسیده است"
            ];
        }

        if(count($coupons->lms_factors) > $coupons['usage_count']){
            return [
                'status' => false,
                'error' => "تعداد قابل استفاده این کد تخفیف تمام شده است"
            ];
        }
        
        $time = new Time($coupons['expiry_date']);
        $interval = date_diff( date_create($time->format('Y-m-d')), date_create( Time::now()->format('Y-m-d')) );
        if($interval->format('%R%a') > 0){
            return [
                'status' => false,
                'error' => "زمان استفاده از این کد تخفیف به پایان رسیده است"
            ];
        }
        
        $user_factor = $this->LmsFactors->find('all')
            ->where([
                'LmsFactors.lms_coupon_id'=> $coupons['id'],
                'LmsFactors.user_id'=> $this->request->getAttribute('identity')->get('id'),
                //'LmsFactors.paid' => 1
            ])
            ->contain(['LmsUserfactors'])
            ->toarray();

        if(count($user_factor) >= $coupons['usage_limit_per_user']){
            return [
                'status' => false,
                'error' => "شما قبلا ازین کد تخفیف برای فاکتورهای دیگری استفاده کرده اید.<Br>
                 در صورتی که فاکتور پرداخت نشده دارید میتوانید کدتخفیف سایرفاکتور ها را حذف و در این فاکتور استفاده نمایید"
            ];
        }
        
        if($coupons['product_ids'] != null){
            $product_ids = json_decode($coupons['product_ids'],false);
            if(is_array($product_ids) and count($product_ids) > 0){
                $results = $this->LmsFactors->find('all')
                    ->where([
                        'LmsFactors.id'=> $factors[0]['id'],
                        'LmsFactors.paid' => 0 ])
                    ->contain(['LmsUserfactors']);
                $results = $results->matching('LmsUserfactors',
                    function ($q) use ($product_ids){
                        return $q->where(['LmsUserfactors.lms_course_id IN ' => $product_ids ]);
                    });
                $results = $results->first();
                if(!$results){
                    return [
                        'status' => false,
                        'error' => "کد تخفیف وارد شده برای این دوره تعریف نشده است"
                    ];
                }
            }
        }

        return $coupons;
    }
    //----------------------------------------------------------------
    public function factors($id = null)
    {
       
        if($this->request->getQuery('id')){
            $id = $this->request->getQuery('id');
        }

        $factors = $this->LmsFactors->find('all')
            ->where([
                $id != null?['LmsFactors.id'=>$id]:false,
                'LmsFactors.user_id'=> $this->request->getAttribute('identity')->get('id')
                ])
            ->contain(['LmsUserfactors'=>['LmsCourses'],'LmsPayments','LmsCoupons'])
            ->order(['LmsFactors.id'=>'desc'])
            ->toarray();
        
        if($id != null and !$factors){
            $this->Flash->error('فاکتوری پیدا نشد');
            return $this->redirect('/lms/client/factors');
        }
        $this->set([
            'factors' => $factors,
        ]);

        if($this->request->is('post') and isset($this->request->getData()['coupons'])){
            $coupon_data = $this->_Coupons_Check($factors, $this->request->getData());
            if(isset($coupon_data['status']) and $coupon_data['status'] == false){
                $this->Flash->error($coupon_data['error']);
                return $this->redirect($this->referer());
            }
            else
                $this->Flash->success($coupon_data['descr']);

            $new_price = 0;
            switch ($coupon_data['discount_type']) {
                case 'percent':
                    $new_price = $factors[0]['price'] - (($factors[0]['price'] * $coupon_data['maximum_amount']) / 100);
                    break;
                case 'fixed_product':
                    $new_price = $factors[0]['price'] - $coupon_data['maximum_amount'];
                    break;
                default:
                    $new_price = $factors[0]['price'];
                    break;
            }
            if($new_price >= 0){
                $tmp = $this->LmsFactors->query()
                    ->update()
                    ->set([
                        'old_price' => $factors[0]['price'],
                        'price' => $new_price,
                        'lms_coupon_id'=>$coupon_data['id']
                        ])
                    ->where(['LmsFactors.id' => $factors[0]['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                    ->execute();
                if($tmp){
                    $this->Flash->success("اعمال کدتخفیف با موفقیت انجام و مبلغ فاکتور بروزرسانی شد");
                    if($new_price == 0){
                        return $this->redirect(['?'=>[
                            'id'=>$factors[0]['id'],
                            'payment'=>true , 
                            'auto_success_payment'=>true]]);  
                    }
                }
                else{
                    $this->Flash->error("متاسفانه بروزرسانی فاکتور انجام نشد");
                }
                return $this->redirect($this->referer());
            }
            else{
                $this->Flash->error("وضعیت کدتخفیف نامشخص است - از پشتیبانی پیگیری نمایید");
            }
        }

        if($this->request->is('post') and $this->request->getQuery('coupons') == "delete"){
            $tmp = $this->LmsFactors->query()
                ->update()
                ->set([
                    'old_price' => null,
                    'price' => $factors[0]['old_price'],
                    'lms_coupon_id'=> null
                    ])
                ->where(['LmsFactors.id' => $factors[0]['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                ->execute();
            if($tmp)
                $this->Flash->success("حذف کدتخفیف با موفقیت انجام و مبلغ فاکتور بروزرسانی شد");
            else
                $this->Flash->error("متاسفانه بروزرسانی فاکتور انجام نشد");
            
            return $this->redirect($this->referer());
        }

        if($this->request->getQuery('payment')){
            if($this->request->getQuery('auto_success_payment'))
                $status = true;
            else
                $status = $this->factor_payment($factors);

            if($status){
                $userf = $this->LmsUserfactors->find('all')
                    ->where([
                        'lms_factor_id'=>$factors[0]['id'] , 
                        'user_id'=>$this->request->getAttribute('identity')->get('id')
                    ])
                    ->first();
                if($userf){
                    if($userf->lms_exam_id == "")
                        $userf->enable = 1;
                    
                    if($this->LmsUserfactors->save($userf)){

                        if(isset($userf->lms_course_id) and $userf->lms_course_id != ''){
                            
                            if($userf->lms_exam_id == "")
                            {
                                //Renew Day
                                $add_month = 0;
                                $Course_renewday = 30;
                                if( count($factors) == 1 ){
                                   
                                    //lms_userfactor
                                    if(isset($factors[0]['lms_userfactor']['lms_course'])){
                                        $lms_course = $factors[0]['lms_userfactor']['lms_course'];

                                        //تمدید پیش فرض
                                        $Course_renewday = (isset($lms_course['renew_day']) and $lms_course['renew_day'] !='')
                                            ?
                                            $factors[0]['lms_userfactor']['lms_course']['renew_day']
                                            :30;

                                        //تمدید بر اساس بازه زمانی
                                        if(isset(json_decode($factors[0]['options'],true)['renew_day'])
                                            and json_decode($factors[0]['options'],true)['renew_day'] != ""){
                                                $add_month = json_decode($factors[0]['options'],true)['renew_day'];
                                        }
                                    }
                                    
                                    //lms_userfactor(s)
                                    if(isset($factors[0]['lms_userfactors'][0]['lms_course'])){
                                        $lms_course = $factors[0]['lms_userfactors'][0]['lms_course'];

                                        //تمدید پیش فرض
                                        $Course_renewday = (isset($lms_course['renew_day']) and $lms_course['renew_day'] !='')
                                            ?
                                            $factors[0]['lms_userfactor']['lms_course']['renew_day']
                                            :30;

                                        //تمدید بر اساس بازه زمانی
                                        if(isset(json_decode($factors[0]['options'],true)['renew_day'])
                                            and json_decode($factors[0]['options'],true)['renew_day'] != ""){
                                                $add_month = json_decode($factors[0]['options'],true)['renew_day'];
                                        }
                                    }

                                }
                                
                                $tmp = $this->LmsCourseusers->find('all')->where([
                                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                                    'lms_course_id' => $userf->lms_course_id
                                ])
                                ->first();

                                if($tmp){
                                    $checker = new Checker();
                                    $day = $checker->GetCourseuser_StartDate($factors[0]['lms_userfactors'][0]['lms_course'],$tmp); 
                                    $time = new Time($tmp['created']);
                                    $time->addDays($day);

                                    if($add_month > 0){
                                        $time = $time->addMonth($add_month);
                                    }
                                    else{
                                        $time = $time->addDays($Course_renewday);
                                    }

                                    $lmsCourseuser = $this->LmsCourseusers->get($tmp['id']);
                                    $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                                        'created' => $time->format('Y-m-d H:i:s'),
                                        'enable' => 1,
                                    ]);
                                    if($this->LmsCourseusers->save($lmsCourseuser)){
                                        $this->Flash->success('دوره برای شما تمدید شد، در منوی «حساب من» در قسمت 
                                            <a href="'.Router::url('/lms/client/course/').'">«دوره ها»</a>
                                                اقدام به مشاهده دوره کنید.');
                                    }else{
                                        $this->Flash->error('متاسفانه، دوره درخواست شده تمدید نگردید- از طریق پشتیبانی پیگیری کنید -کد30  ');
                                    }
                                }
                                else{
                                    $lmsCourseuser = $this->LmsCourseusers->newEmptyEntity(();
                                    $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                                        'lms_course_id' => $userf->lms_course_id
                                    ]);
                                    if($this->LmsCourseusers->save($lmsCourseuser)){
                                        $this->Flash->success('دوره برای شما ثبت و فعال شد، در منوی «حساب من» در قسمت 
                                            <a href="'.Router::url('/lms/client/course/').'">«دوره ها»</a>
                                            اقدام به مشاهده دوره کنید.');
                                    }else{
                                        $this->Flash->error('متاسفانه، دوره درخواست شده فعال نگردید- از طریق پشتیبانی پیگیری کنید -کد31  ');
                                    }
                                }
                            }

                            if($this->request->getQuery('auto_success_payment')){
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors[0]['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                            }

                            if(isset($this->setting['payment_redirect']) and $this->setting['payment_redirect'] != ''){
                                return $this->redirect($this->setting['payment_redirect']);
                            }

                        }
                        else{
                            $this->Flash->success('وضعیت پرداخت با موفقیت در سیستم ثبت گردید');
                        }
                        
                    }
                    else{
                        $this->Flash->error('متاسفانه دوره درخواست شده فعال نگردید- از طریق پشتیبانی پیگیری کنید -کد19');
                    }
                    return $this->redirect('/lms/client/factors?id='.$id);
                }
            }
            return $this->render('factor_payment');
        }
        elseif($id != null)
            return $this->render('factor_detail');

    }
    //----------------------------------------------------------------
    private function factor_payment($factors = null)
    {
        $factors = $factors[0];
        if(! $this->request->getQuery('order')){
            $pay = $this->LmsPayments->patchEntity($this->LmsPayments->newEmptyEntity((),[
                'user_id'=> $this->request->getAttribute('identity')->get('id'),
                'price'=> $factors['price'],
                'lms_factor_id'=> $factors['id'],
                'token'=> $factors['id'].date('hi').rand(10000,99999),
                'terminal_ids'=> $this->setting['terminal_list'],
                'status'=> 0,
                'enable'=> 0,
            ]);
            if (!$this->LmsPayments->save($pay)) {
                $this->Flash->error('امکان ارسال برای پرداخت میسر نشد');
                return $this->redirect('/lms/client/factors');
            }
        }
        else{
            $pay = $this->LmsPayments->find('all')
                ->where([
                    'lms_factor_id'=> $factors['id'],
                    'token'=> $this->request->getQuery('order') ])
                ->first();
            if (!$pay) {
                $this->Flash->error('امکان فعالیت این پرداخت میسر نشد');
                return $this->redirect('/lms/client/factors');
            }
        }        
        //header('Set-Cookie: cookie2=value2; SameSite=None; Secure', true);
        //ini_set('session.cookie_samesite', 'None');
        /*
        https://asanwebhost.com/announcements/11
        .htaccess
        <ifmodule mod_headers.c="">
            Header always edit Set-Cookie ^(.*)$ $1;SameSite=None;Secure
        </ifmodule>
        */

        $Amount = str_replace( ',', '', $factors['price']);
        $OrderId = $pay->token;
        $CallbackURL = Router::url(false,true).'&order='.$OrderId;
        //$CallbackURL =Router::url('/',true).'/lms/client/factors?id='.$factors['id'].'&order='.$OrderId;

       
        switch ($this->setting['terminal_list']) {
            case '4':
            case 'zarrinpal':
                $MerchantID 	= $this->setting['merchant_id'];
                $Description 	= "توضیحات";//strip_tags($_POST['descr']);
                $Email 			= "test@test.ir";
                $Mobile 		= "";//strip_tags($_POST['mobile']);
                $ZarinGate 		= false;
                $SandBox 		= false;
                $p = $this->LmsPayments->get($pay->id);
                if($this->request->is('post')){
                    $zp = new zarinpal();
                    $result = $zp->request($MerchantID, $Amount, $Description, $Email, $Mobile, $CallbackURL, $SandBox, $ZarinGate);
                    if (isset($result["Status"]) && $result["Status"] == 100){
                        $p->auth = $result['Authority'];
                        $p->status = 0;
                        $p = $this->LmsPayments->save($p);
                        if($p) $zp->redirect($result["StartPay"]);
                    } else {
                        $p->RefID = isset($result["RefID"])?$result["RefID"]:'';
                        $p->Errcode = isset($result["Status"])?$result["Status"]:'';
                        $p->Errtext = isset($result['Message'])?$result['Message']:'';
                        $p->status = 0;
                        $p->enable = 0;
                        $p = $this->LmsPayments->save($p);
                        return false;
                    }
                }
                elseif(isset($_GET['Authority'])){
                    $ZarinGate 		= false;
                    $SandBox 		= false;
                    $zp 	= new zarinpal();
                    if ($_GET["Status"] == 'OK' ) {
                        $result = $zp->verify($MerchantID, $Amount, $SandBox, $ZarinGate);
                        if (isset($result["Status"]) && ($result["Status"] == 100 or $result["Status"] == 101)){
                            $p->RefID = $result["RefID"];
                            $p->Errcode = $result["Status"];
                            $p->Errtext = $result['Message'];
                            $p->status = 1;
                            $p->enable = 1;
                            $p = $this->LmsPayments->save($p);
                            if($p){
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت هزینه دوره با موفقیت انجام شد.'));
                                return $p->id;
                            }else{
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت انجام شده ولی ثبت سیستمی نشد - کد 15'));
                                return $p->id;
                            }
                        }
                        else {
                            $p->RefID = $result["RefID"];
                            $p->TraceID = ($result["Status"].'/'.$result["Message"]);
                            $p->Errcode = $result["Status"];
                            $p->Errtext = $result['Message'];
                            $p->status = 0;
                            $p = $this->LmsPayments->save($p);
                            if($p){
                                $this->Flash->error(__('متاسفانه پرداخت با موفقیت انجام نشد'));
                                return false;
                            }else{
                                $this->Flash->error(__('متاسفانه پرداخت با موفقیت انجام نشد. ثبت سیستم انجام نشد - کد 16'));
                                return false;
                            }
                        }
                    }
                    elseif ($_GET["Status"] == 'NOK' ) {
                        $result = $zp->verify($MerchantID, $Amount, $SandBox, $ZarinGate);
                        $p->RefID = $result["RefID"];
                        $p->Errcode = $result["Status"];
                        $p->Errtext = $result['Message'];
                        $p->status = 0;
                        $p = $this->LmsPayments->save($p);
                        $this->Flash->error(__('متاسفانه پرداخت با موفقیت انجام نشد'));
                        return false;
                    }
                    //return $this->redirect('/lms/client/factors?id='.$factors['id']);
                }
            break;
            //----//
            case '1':
            case 'melli':
                $melli_func = new Melli();
                $MerchantId 	= $this->setting['merchant_id'];
                $Terminal_key 	= $this->setting['terminal_key'];
                $TerminalId 	= $this->setting['terminal_id'];
                $Amount = $Amount * 10;
                $Description 	= "";//strip_tags($_POST['descr']);
                $Email 			= "";
                $Mobile 		= "";//strip_tags($_POST['mobile']);
                $p = $this->LmsPayments->get($pay->id);
                if($this->request->is('post') and !$this->request->getQuery('order') ){
                    
                    $SignData = $melli_func->encrypt_pkcs7("$TerminalId;$OrderId;$Amount","$Terminal_key");
                    $data = array(
                        'TerminalId' => $TerminalId,
                        'MerchantId' => $MerchantId,
                        'Amount' => $Amount,
                        'SignData' => $SignData,
                        'ReturnUrl' => $CallbackURL,
                        'LocalDateTime' => date("m/d/Y g:i:s a"),
                        'OrderId' => $OrderId
                    );
                     
                    $result = $melli_func->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest', $data);
                    if ($result->ResCode == 0) {
                        $p->auth = $result->Token;
                        $p->status = 1;
                        $p = $this->LmsPayments->save($p);
                        $url = "https://sadad.shaparak.ir/VPG/Purchase?Token=".$result->Token;
                        header("Location:$url");
                        exit;
                    }
                    else {
                        $p->RefID = '';
                        $p->Errcode = $result->ResCode;
                        $p->Errtext = $result->Description;
                        $p->status = 0;
                        $p->enable = 0;
                        $p = $this->LmsPayments->save($p);
                        return false;
                    }
                }
                else{
                    if(isset($_POST["token"])){
                        $OrderId = $_POST["OrderId"];
                        $Token = $_POST["token"];
                        $ResCode = $_POST["ResCode"];
                        
                        $result = null;
                        if ($ResCode == 0) {
                            $verifyData = array(
                                'Token' => $Token,
                                'SignData' =>  $melli_func->encrypt_pkcs7($Token, $Terminal_key)
                            );
                            $result = $melli_func->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify', $verifyData);
                        }

                        $p->RefID = isset($result->RetrivalRefNo)?$result->RetrivalRefNo:'';
                        $p->TraceID =  isset($result->SystemTraceNo)?$result->SystemTraceNo:'';
                        $p->Errcode =  isset($result->ResCode)?$result->ResCode:'';
                        $p->Errtext =  isset($result->Description)?$result->Description:'';
                        if ($result!= null and $result->ResCode != -1 && $result->ResCode == 0) {
                            $p->status = 1;
                            $p->enable = 1;
                            $p = $this->LmsPayments->save($p);
                            if($p){
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت هزینه دوره با موفقیت انجام شد.'));
                                return $p->id;
                            }else{
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت انجام شده ولی ثبت سیستمی نشد - کد 15'));
                                return $p->id;
                            }
                        }
                        else{
                            $p->status = 0;
                            $p->enable = 0;
                            $p = $this->LmsPayments->save($p);
                            $this->Flash->error("تراکنش نا موفق بود در صورت کسر مبلغ از حساب شما حداکثر پس از 72 ساعت مبلغ به حسابتان برمی گردد."); 
                            return false;
                        }
                    }
                    else{
                        $this->Flash->error("اطلاعات ارسال شده اشتباه هست.از پشتیبانی پیگیری کنید."); 
                        return false;
                    }
                }
            break;
            //----//
            case '3':
            case 'sep': //sep
                $MerchantId 	= $this->setting['merchant_id'];
                $Terminal_key 	= $this->setting['terminal_key'];
                $TerminalId 	= $this->setting['terminal_id'];
                $Amount = $Amount * 10;
                $Description 	= "";//strip_tags($_POST['descr']);
                $Email 			= "";
                $Mobile 		= $this->request->getAttribute('identity')->get('username');//strip_tags($_POST['mobile']);
                $p = $this->LmsPayments->get($pay->id);
                
                if($this->request->is('post') and !isset($_POST['StateCode']) ){
                    $client = new soapclient('https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL');
                    $result = $client->RequestToken(
                            $MerchantId,/// MID 
                            $OrderId,/// ResNum
                            $Amount/// TotalAmount
                            ,$Mobile/// Optional
                            ,$Description/// Optional 
                            ,'0'			/// Optional
                            ,'0'			/// Optional
                            ,'0'			/// Optional
                            ,'0'			/// Optional
                            ,'ResNum1'		/// Optional
                            ,'ResNum2'		/// Optional
                            ,'0'			/// Optional
                            ,$CallbackURL //$RedirectURL	/// Optional
                        );

                    if ($result && strlen($result)> 15){
                        $p->auth = $result;
                        $p->status = 1;
                        $p = $this->LmsPayments->save($p);
                        //$url = "https://sadad.shaparak.ir/VPG/Purchase?Token=".$result->Token;
                        //header("Location:$url");
                        ?>
                        در حال هدایت به درگاه پرداخت . لطفا منتظر بمانید   ...
                        <form action='https://sep.shaparak.ir/payment.aspx' method='POST' id='myFormss' style="visibility:hidden">
                            <input name='token' type='hidden' value='<?=$result?>'>
                            <input name='RedirectURL' type='hidden' value='<?=$CallbackURL?>'>
                            <input name='btn' type='submit' value='در حال هدایت به درگاه پرداخت . در صورتی نیاز اینجا را کلیک کنید   ...'>
                        </form>
                        <script type="text/javascript">
                            window.onload=function(){
                                var auto = setTimeout(function(){ autoRefresh(); }, 1);
                                function submitform(){document.forms["myFormss"].submit();}
                                function autoRefresh(){
                                    clearTimeout(auto);auto = setTimeout(function(){ submitform(); autoRefresh(); }, 1000);
                                }
                            }
                        </script>
                        <?php
                        exit;
                    } else {
                        echo "خطا در ایجاد تراکنش";
                        //echo "<br />کد خطا : ". $response["Status"];
                        //echo "<br />تفسیر و علت خطا : ". $response["Message"];
                    }
                }
                else{

                    if(isset($_POST['StateCode']) ){
                        if ( $_POST['StateCode'] = 2) {

                            $soapclient = new soapclient('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL');
                            $res =  $soapclient->VerifyTransaction($_POST['RefNum'], $_POST['MID']); #reference number and MID

                            $p->RefID = isset($_POST["RefNum"])?$_POST["RefNum"]:'';
                            $p->TraceID =  (isset($_POST["TRACENO"])?$_POST["TRACENO"]:''). 
                                           (isset($_POST["SecurePan"])?'Card_holder: '.$_POST["SecurePan"]:'').
                                           (isset($_POST["RRN"])?' / RRN: '.$_POST["RRN"]:'');
                                           
                            $p->Errcode =  isset($_POST['StateCode'])?$_POST['StateCode']:'';
                            $p->Errtext = "";

                            if ($res > 0 and $res == $Amount){//verified
                                $p->status = 1;
                                $p->enable = 1;
                                $p = $this->LmsPayments->save($p);
                                if($p){
                                    $this->Flash->success(__('پرداخت مبلغ فاکتور با موفقیت انجام شد.'));
                                }else{
                                    $this->Flash->success(__('پرداخت انجام شده ولی ثبت سیستمی نشده و فاکتور به وضعیت پرداخت انجام نشد - کد 15'));
                                }
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();

                                return $p->id;

                                /* $updated = $wpdb->update( 
                                    $query->tblPay, 
                                    array(
                                        'post_id'=> ('SecurePan: '.$_POST["SecurePan"].' / TRACENO: '.$_POST["TRACENO"].' / RRN: '.$_POST["RRN"]),
                                        'descr'=> $data_pay[0]['descr'].'&#13;&#13; shaparak: '.$_POST["RefNum"].'<br>Card_holder:'.$_POST["SecurePan"],
                                        'status'=> 1 ),
                                    array('id'=>$data_pay[0]['id'])
                                ); */
                                /* $result['SystemTraceNo'] = $_POST["RRN"];
                                $result['RetrivalRefNo'] = $_POST["TRACENO"]; */
                            }
                            else{   //khata

                                $p->status = 0;
                                $p->enable = 0;
                                $p = $this->LmsPayments->save($p);
                                $this->Flash->error("تراکنش نا موفق بود در صورت کسر مبلغ از حساب شما حداکثر پس از 72 ساعت مبلغ به حسابتان برمی گردد."); 
                                return false;

                                /* $updated = $wpdb->update( 
                                    $query->tblPay, 
                                    array(
                                        'status'=>0,
                                        'post_id'=> ('SecurePan: '.$_POST["SecurePan"].' / TRACENO: '.$_POST["TRACENO"].' / RRN: '.$_POST["RRN"]),
                                        'pay_id'=>$_POST['RefNum']
                                    ),
                                    array('id'=>$data_pay[0]['id'])
                                ); */
                            }
                        }
                        else{
                            echo "تراکنش ناموفق -  در صورت کسر مبلغ از حساب شما حداکثر پس از 72 ساعت مبلغ به حسابتان برمی گردد.";
                        }

                        /* $pay = $wpdb->get_results("SELECT * FROM {$query->tblPay} where `id`='".$data_pay[0]['id']."' ",ARRAY_A );
                        if(!$pay){
                            //$query->safe_redirect('/');
                        } */
                    }
                    else{
                        //$query->safe_redirect('/');
                    }


                    /* if(isset($_POST["token"])){
                        $OrderId = $_POST["OrderId"];
                        $Token = $_POST["token"];
                        $ResCode = $_POST["ResCode"];
                        
                        $result = null;
                        if ($ResCode == 0) {
                            $verifyData = array(
                                'Token' => $Token,
                                'SignData' =>  $melli_func->encrypt_pkcs7($Token, $Terminal_key)
                            );
                            $result = $melli_func->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify', $verifyData);
                        }

                        $p->RefID = isset($result->RetrivalRefNo)?$result->RetrivalRefNo:'';
                        $p->TraceID =  isset($result->SystemTraceNo)?$result->SystemTraceNo:'';
                        $p->Errcode =  isset($result->ResCode)?$result->ResCode:'';
                        $p->Errtext =  isset($result->Description)?$result->Description:'';
                        if ($result!= null and $result->ResCode != -1 && $result->ResCode == 0) {
                            $p->status = 1;
                            $p->enable = 1;
                            $p = $this->LmsPayments->save($p);
                            if($p){
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت هزینه دوره با موفقیت انجام شد.'));
                                return $p->id;
                            }else{
                                $this->LmsFactors->query()
                                    ->update()
                                    ->set(['paid' => 1,'status' => 1])
                                    ->where(['LmsFactors.id' => $factors['id'],'user_id'=>$this->request->getAttribute('identity')->get('id')])
                                    ->execute();
                                $this->Flash->success(__('پرداخت انجام شده ولی ثبت سیستمی نشد - کد 15'));
                                return $p->id;
                            }
                        }
                        else{
                            $p->status = 0;
                            $p->enable = 0;
                            $p = $this->LmsPayments->save($p);
                            $this->Flash->error("تراکنش نا موفق بود در صورت کسر مبلغ از حساب شما حداکثر پس از 72 ساعت مبلغ به حسابتان برمی گردد."); 
                            return false;
                        }
                    }
                    else{
                        $this->Flash->error("اطلاعات ارسال شده اشتباه هست.از پشتیبانی پیگیری کنید."); 
                        return false;
                    } */
                }
                break;
            default:
                die("هنوز درگاه پرداخت در تنظیمات سامانه انتخاب نشده است");
            break;
        }
    }
    //----------------------------------------------------------------
    public function payments($id = null,$action = null) 
    {
        $factors = $this->LmsPayments->find('all')
            ->where(['LmsPayments.user_id'=> $this->request->getAttribute('identity')->get('id')])
            ->contain(['LmsFactors'])
            ->order(['LmsPayments.id'=>'desc'])
            ->toarray();

        $this->set([
            'payments' => $factors,
        ]);
    }
    //----------------------------------------------------------------
}

class Melli{
    function encrypt_pkcs7($str, $key){
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str, "DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }
    function CallAPI($url, $data = false)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($ch);
            curl_close($ch);
            return !empty($result) ? json_decode($result) : false;
        }
        catch (Exception $ex) {
            return false;
        }
    }
}
class zarinpal{
	private function curl_check(){
		return (function_exists('curl_version')) ? true : false;
	}
	
	private function soap_check()
	{
		return (extension_loaded('soap')) ? true : false;
	}
	
	private function error_message($code, $desc, $cb, $request=false)
	{
		if (empty($cb) && $request === true)
		{
			return "لینک بازگشت ( CallbackURL ) نباید خالی باشد";
		}

		if (empty($desc) && $request === true)
		{
			return "توضیحات تراکنش ( Description ) نباید خالی باشد";
		}
		
		
		$error = array(
			"-1" 	=> "اطلاعات ارسال شده ناقص است.",
			"-2" 	=> "IP و يا مرچنت كد پذيرنده صحيح نيست",
			"-3" 	=> "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
			"-4" 	=> "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
			"-11" 	=> "درخواست مورد نظر يافت نشد.",
			"-12" 	=> "امكان ويرايش درخواست ميسر نمي باشد.",
			"-21" 	=> "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
			"-22" 	=> "تراكنش نا موفق ميباشد",
			"-33" 	=> "رقم تراكنش با رقم پرداخت شده مطابقت ندارد",
			"-34" 	=> "سقف تقسيم تراكنش از لحاظ تعداد يا رقم عبور نموده است",
			"-40" 	=> "اجازه دسترسي به متد مربوطه وجود ندارد.",
			"-41" 	=> "اطلاعات ارسال شده مربوط به AdditionalData غيرمعتبر ميباشد.",
			"-42" 	=> "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
			"-54" 	=> "درخواست مورد نظر آرشيو شده است",
			"100" 	=> "عمليات با موفقيت انجام گرديده است.",
			"101" 	=> "عمليات پرداخت موفق بوده و قبلا PaymentVerification تراكنش انجام شده است.",
		);

		if (array_key_exists("{$code}", $error))
		{
			return $error["{$code}"];
		} else {
			return "خطای نامشخص هنگام اتصال به درگاه زرین پال";
		}
	}

	private function zarinpal_node()
	{
		if ($this->curl_check() === true)
		{
			$ir_ch = curl_init("https://www.zarinpal.com/pg/services/WebGate/wsdl");
			curl_setopt($ir_ch, CURLOPT_TIMEOUT, 1);
			curl_setopt($ir_ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ir_ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ir_ch);
			$ir_info = curl_getinfo($ir_ch);
			curl_close($ir_ch);

			$de_ch = curl_init("https://de.zarinpal.com/pg/services/WebGate/wsdl");
			curl_setopt($de_ch, CURLOPT_TIMEOUT, 1);
			curl_setopt($de_ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($de_ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($de_ch);
			$de_info = curl_getinfo($de_ch);
			curl_close($de_ch);

			$ir_total_time = (isset($ir_info['total_time']) && $ir_info['total_time'] > 0) ? $ir_info['total_time'] : false;
			$de_total_time = (isset($de_info['total_time']) && $de_info['total_time'] > 0) ? $de_info['total_time'] : false;

			return ($ir_total_time === false || $ir_total_time > $de_total_time) ? "de" : "ir";
		} else {
			if (function_exists('fsockopen'))
			{
				$de_ping 	= $this->zarinpal_ping("de.zarinpal.com", 80, 1);
				$ir_ping 	= $this->zarinpal_ping("www.zarinpal.com", 80, 1);

				$de_domain 	= "https://de.zarinpal.com/pg/services/WebGate/wsdl";
				$ir_domain 	= "https://www.zarinpal.com/pg/services/WebGate/wsdl";

				$ir_total_time = (isset($ir_ping) && $ir_ping > 0) ? $ir_ping : false;
				$de_total_time = (isset($de_ping) && $de_ping > 0) ? $de_ping : false;

				return ($ir_total_time === false || $ir_total_time > $de_total_time) ? "de" : "ir";
			} else {
				$webservice = "https://www.zarinpal.com/pg/services/WebGate/wsd";
				$headers 	= @get_headers($webservice);

				return (strpos($headers[0], '200') === false) ? "de" : "ir";
			}
		}
	}
	
	private function zarinpal_ping($host, $port, $timeout)
	{
		$time_b 	= microtime(true);
		$fsockopen 	= @fsockopen($host, $port, $errno, $errstr, $timeout);

		if (!$fsockopen)
		{
			return false;
		}  else {
			$time_a = microtime(true); 
			return round((($time_a - $time_b) * 1000), 0); 
		}
	}

	public function redirect($url)
	{
		@header('Location: '. $url);
		echo "<meta http-equiv='refresh' content='0; url={$url}' />";
		echo "<script nonce='".get_nonce."'>window.location.href = '{$url}';</script>";
		exit;
	}

	public function request($MerchantID, $Amount, $Description="", $Email="", $Mobile="", $CallbackURL, $SandBox=false, $ZarinGate=false)
	{
		$ZarinGate = ($SandBox == true) ? false : $ZarinGate;

		if ($this->soap_check() === true)
		{
			$node 	= ($SandBox == true) ? "sandbox" : $this->zarinpal_node();
			$upay 	= ($SandBox == true) ? "sandbox" : "www";

			$client = new SoapClient("https://{$node}.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);

			$result = $client->PaymentRequest([
				'MerchantID'     => $MerchantID,
				'Amount'         => $Amount,
				'Description'    => $Description,
				'Email'          => $Email,
				'Mobile'         => $Mobile,
				'CallbackURL'    => $CallbackURL,
			]);

			$Status 		= (isset($result->Status) 		&& $result->Status != "") 		? $result->Status : 0;
			$Authority 		= (isset($result->Authority) 	&& $result->Authority != "") 	? $result->Authority : "";
			$StartPay 		= (isset($result->Authority) 	&& $result->Authority != "") 	? "https://{$upay}.zarinpal.com/pg/StartPay/". $Authority : "";
			$StartPayUrl 	= (isset($ZarinGate) 			&& $ZarinGate == true) 			? "{$StartPay}/ZarinGate" : $StartPay;

			return array(
				"Node" 		=> "{$node}",
				"Method" 	=> "SOAP",
				"Status" 	=> $Status,
				"Message" 	=> $this->error_message($Status, $Description, $CallbackURL, true),
				"StartPay" 	=> $StartPayUrl,
				"Authority" => $Authority
			);
		} else {
			$node 	= ($SandBox == true) ? "sandbox" : "ir";
			$upay 	= ($SandBox == true) ? "sandbox" : "www";

			$data = array(
				'MerchantID'     => $MerchantID,
				'Amount'         => $Amount,
				'Description'    => $Description,
				'CallbackURL'    => $CallbackURL,
			);

			$jsonData = json_encode($data);
			$ch = curl_init("https://{$upay}.zarinpal.com/pg/rest/WebGate/PaymentRequest.json");
			curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonData)));

			$result = curl_exec($ch);
			$err 	= curl_error($ch);
			curl_close($ch);

			$result = json_decode($result, true);

			if ($err)
			{
				$Status 		= 0;
				$Message 		= "cURL Error #:" . $err;
				$Authority 		= "";
				$StartPay 		= "";
				$StartPayUrl 	= "";
			} else {
				$Status 		= (isset($result["Status"]) 	&& $result["Status"] != "") 	? $result["Status"] : 0;
				$Message 		= $this->error_message($Status, $Description, $CallbackURL, true);
				$Authority 		= (isset($result["Authority"]) 	&& $result["Authority"] != "") 	? $result["Authority"] : "";
				$StartPay 		= (isset($result["Authority"]) 	&& $result["Authority"] != "") 	? "https://{$upay}.zarinpal.com/pg/StartPay/". $Authority : "";
				$StartPayUrl 	= (isset($ZarinGate) 			&& $ZarinGate == true) 			? "{$StartPay}/ZarinGate" : $StartPay;
			}

			return array(
				"Node" 		=> "{$node}",
				"Method" 	=> "CURL",
				"Status" 	=> $Status,
				"Message" 	=> $Message,
				"StartPay" 	=> $StartPayUrl,
				"Authority" => $Authority
			);
		}
	}

	public function verify($MerchantID, $Amount, $SandBox=false, $ZarinGate=false)
	{
		$ZarinGate = ($SandBox == true) ? false : $ZarinGate;

		if ($this->soap_check() === true)
		{
			$au 	= (isset($_GET['Authority']) && $_GET['Authority'] != "") ? $_GET['Authority'] : "";
			$node 	= ($SandBox == true) ? "sandbox" : $this->zarinpal_node();

			$client = new SoapClient("https://{$node}.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);

			$result = $client->PaymentVerification([
				'MerchantID'     => $MerchantID,
				'Authority'      => $au,
				'Amount'         => $Amount,
			]);

			$Status 		= (isset($result->Status) 		&& $result->Status != "") 		? $result->Status 	: 0;
			$RefID 			= (isset($result->RefID) 		&& $result->RefID != "") 		? $result->RefID 	: "";
			$Message 		= $this->error_message($Status, "", "", false);

			return array(
				"Node" 		=> "{$node}",
				"Method" 	=> "SOAP",
				"Status" 	=> $Status,
				"Message" 	=> $Message,
				"Amount" 	=> $Amount,
				"RefID" 	=> $RefID,
				"Authority" => $au
			);	
		} else {
			$au 	= (isset($_GET['Authority']) && $_GET['Authority'] != "") ? $_GET['Authority'] : "";
			$node 	= ($SandBox == true) ? "sandbox" : "ir";
			$upay 	= ($SandBox == true) ? "sandbox" : "www";
			
			$data = array('MerchantID' => $MerchantID, 'Authority' => $au, 'Amount' => $Amount);
			$jsonData = json_encode($data);
			$ch = curl_init("https://{$upay}.zarinpal.com/pg/rest/WebGate/PaymentVerification.json");
			curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonData)));

			$result = curl_exec($ch);
			$err 	= curl_error($ch);
			curl_close($ch);

			$result = json_decode($result, true);

			if ($err)
			{
				$Status 		= 0;
				$Message 		= "cURL Error #:" . $err;
				$Status 		= "";
				$RefID 			= "";
			} else {
				$Status 		= (isset($result["Status"]) && $result["Status"] != "") ? $result["Status"] : 0;
				$RefID 			= (isset($result['RefID']) 	&& $result['RefID'] != "") 	? $result['RefID'] 	: "";
				$Message 		= $this->error_message($Status, "", "", false);
			}

			return array(
				"Node" 		=> "{$node}",
				"Method" 	=> "CURL",
				"Status" 	=> $Status,
				"Message" 	=> $Message,
				"Amount" 	=> $Amount,
				"RefID" 	=> $RefID,
				"Authority" => $au
			);	
		}
	}
}