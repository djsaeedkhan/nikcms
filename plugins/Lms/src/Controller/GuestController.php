<?php
namespace Lms\Controller;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Lms\Checker;
use Lms\Controller\AppController;
use Lms\Model\Entity\LmsCourse;
use Lms\VideoStream;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\View\Exception\MissingLayoutException;
use Lms\Video;

class GuestController extends AppController
{
    public function initialize() {
        parent::initialize();
        try {
            $layout = 'Template.lms-index';
            $this->viewBuilder()->setLayout($layout);
        } catch (Exception $e) {
            $layout = 'Admin.default';
            $this->viewBuilder()->setLayout($layout);
        }
        /* finally {
            $layout = 'Admin.default';
            $this->viewBuilder()->setLayout($layout);
        } */
        
        /* if (!$this->viewBuilder()->getLayoutPath($layout)) {
            $layout = 'Admin.default';
        } */

    }
    //----------------------------------------------------------
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index','view','detail','courses','register','subscribe']);
    }
    //----------------------------------------------------------------
    public function index() {

        $lmsCourseCategories = $this->LmsCoursecategories->find('all')
            ->order(['LmsCoursecategories.priority'=>'asc'])
            ->toarray();

        $lmsCourses = $this->LmsCourses->find('all')
            ->where([
                ($this->request->getQuery('cat')?['lms_coursecategorie_id'=>$this->request->getQuery('cat')]:false),
                'show_in_list'=> 1 ,
                'enable'=>1])
            ->contain([
                'LmsCoursefiles',
                'LmsCourserelateds'=>['LmsCoursess'],
                'LmsCourseweeks'=>['LmsCoursefiles']])
            ->order(['LmsCourses.priority'=>'asc'])
            ->toarray();

        $lmsCoursefiles = [];
        $lmsCoursefilecan = [];
        $lmsCourseexam = [];

        foreach($lmsCourses as $lms){ 
            $lms_id = $lms['id'];
            $lmsCoursefiles[  $lms_id ] =  $this->LmsCoursefiles
                ->find('list',['keyField' => 'id','valueField' => 'id'])
                ->where(['lms_course_id'=>  $lms_id ])
                ->toarray();

            if (count($lmsCoursefiles[$lms_id ])) {
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
        $this->set(compact(
            'lmsCourses',
            'lmsCoursefilecan',
            'lmsCoursefiles',
            'lmsCourseexam',
            'lmsCourseCategories'
        ));
        if(is_array( $lmsCourseCategories) and count( $lmsCourseCategories) > 0 and !$this->request->getQuery('cat'))
            $this->render('index_categories');
    }
    //----------------------------------------------------------------
    public function courses($id = null , $file = null) {

        $results = $lmsCourses = $this->LmsCourses->find('all')
            ->contain([
                'LmsCourserelateds'=>['LmsCoursess'],
                'lmsCourseweeks'=> [
                    'sort' => ['LmsCourseweeks.priority'=>'ASC'],
                    'lmsCoursefiles'=>['lmsCoursefilenotes','LmsCourseexams'=>'LmsExams'] ]])
            ->where(['LmsCourses.id' =>$id,'show_in_list'=> 1 ,'enable'=>1])
            ->first();

        if(! $lmsCourses){
            $this->Flash->error('چنین دوره ای پیدا نشد');
            $this->redirect($this->referer());
        }

        $file_id = null;
        $pp = $this->LmsCoursefiles->find('list',['keyField'=>'id'])
            ->where(['lms_course_id' => $id ])
            ->order(['priority'=>'ASC' ])
            ->toarray();
        if($this->request->getQuery('qty') ){
            $this->set([
                'qty' => $this->request->getQuery('qty')
            ]);
        }

        //--------------------------------
        $file_id = $this->request->getQuery('file');
        $file = $this->LmsCoursefiles->find('all')
            ->contain(['lmsCoursefilenotes','lmsCourseweeks'])
            ->where([ 'LmsCoursefiles.id' => $file_id,'show_in_list'=>1 ])
            ->enablehydration(false)
            ->first();
        if(isset($file_id) and !$file){
            $this->Flash->error('دسترسی به این محتوا برای شما مقدور نمی باشد');
            return $this->redirect('/lms/');
        }
        /* $show_current = false; */
        $show_current = true;
        /* if($checks->checkIS($id,$file_id , $this->request->getAttribute('identity')->get('id'),  $this->request->getQuery() )){
            $show_current = true;
        } */
        $this->set(['show_current' => $show_current]);
        //--------------------------------

        $this->set([
            'results' => $results,
            'page' => $this->request->getQuery('file') ?$this->request->getQuery('file') :0 ,
            'file' => $file,
            'file_id'=> $file_id
        ]);

        if(isset($this->request->getParam('?')['detail'])){
            $this->render('course_detail');
        }
        elseif(isset($this->request->getParam('?')['register'])){
            $this->render('course_register');
        }
        else
            $this->render('course_index');
    }
    //----------------------------------------------------------------
    public function subscribe($id = null ) {
        $lmsCourses = $this->LmsCourses->find('all')
            ->contain(['LmsCourserelateds'=>['LmsCoursess']])
            ->where(['LmsCourses.id' =>$id,'show_in_list'=> 1 ,'enable'=>1] )
            ->first();

        if(! $lmsCourses){
            $this->Flash->error('چنین دوره ای پیدا نشد');
            return $this->redirect($this->referer());
        }
        if($lmsCourses['can_add'] != 1){
            $this->Flash->error('در حال حاضر امکان ثبت نام در این دوره امکان پذیر نمی باشد.');
            return $this->redirect($this->referer());
        }

        if(! $this->request->getAttribute('identity')->get('id')){
            $this->Flash->error('برای ثبت نام در دوره می بایست به حساب کاربری خود وارد شوید. اگر حساب کاربری ندارید، '
                .'<a href="'.$this->Func->Urls('register').'">اینجا</a> را کلیک کنید.');
            return $this->redirect($this->referer());
        }

        if($this->LmsCourseusers->find('all')
            ->where(['user_id'=>$this->request->getAttribute('identity')->get('id'),'lms_course_id'=>$id])
            ->count() > 0 ){
                $this->Flash->error('دوره "'.$lmsCourses['title'].'" قبلا برای شما ثبت شده است.');
                return $this->redirect($this->referer());
        }

        if($this->LmsUserfactors->find('all')
            ->where([
                'user_id'=>$this->request->getAttribute('identity')->get('id'),
                'lms_course_id'=>$lmsCourses['id'],
                'enable'=>0,
            ])
            ->count() > 0 ){
                $this->Flash->error('برای این دوره فاکتور پرداخت نشده ثبت شده است..<br>
                 لطفا نسبت به پرداخت آن از طریق پنل کاربری اقدام نمایید.');
                return $this->redirect($this->referer());
        }

        // بررسی فاصله زمانی بین دو فاکتور
        $time = Time::now();
        if(isset($this->setting['course_time_between_two_factors']) and $this->setting['course_time_between_two_factors']!= ""){
            $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
            $time->addDays("-".intval($this->setting['course_time_between_two_factors']));

            $factor = $this->LmsUserfactors->find('all')
                ->order(['Created'=>'DESC'])
                ->where([
                    'enable'=> true,
                    'user_id' => $this->request->getAttribute('identity')->get('id'),
                    'created >= '=> $time->format('Y-m-d H:i:s'),
                ])
                ->toarray();

            if(count($factor) > 0 ){
                $delay = $this->Func->DiffDate($time->format('Y-m-d') , $factor[0]['created']->format('Y-m-d H:i:s') );
                echo 'شماره در حال حاضر یک فاکتور ثبت شده دارید. ';

                if(isset($this->setting['course_time_between_two_factors_alert']) and $this->setting['course_time_between_two_factors_alert']!= ""){
                    $this->Flash->error($this->setting['course_time_between_two_factors_alert']);
                }
                else{
                    $this->Flash->error(
                        'شما از قبل فاکتور شده ثبت دارید..<br> پس از '.
                        intval($delay) .' روز دیگر امکان ثبت فاکتور جدید برای شما امکان پذیر خواهد بود');
                }
                return $this->redirect($this->referer());
            }
        }
        if(isset($lmsCourses['lms_courserelateds']) and count($lmsCourses['lms_courserelateds']) > 0){
            $related = true;

            //محاسبه میکند که چه مدت پس از گذراندن پیش نیاز ها، اجازه گرفتن درس اصلی وجود داشته باشد
            $time = Time::now();
            if(isset($this->setting['course_related_limit']) and $this->setting['course_related_limit']!= ""){
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                $time->addDays("-".$this->setting['course_related_limit']);
            }
            
            foreach($lmsCourses['lms_courserelateds'] as $related){


                $relateds = $this->LmsCourseusers->find('all')
                    ->where([
                        'user_id'=>$this->request->getAttribute('identity')->get('id'),
                        'lms_course_id'=>$related['lms_course_ids']])
                    ->toarray();

                    echo $relateds[0]['created']->format('Y-m-d H:i:s').'<br>';
                    echo $time->format('Y-m-d H:i:s').'<br>';

                if(count($relateds) == 0 ){
                        $this->Flash->error('پیش نیاز: ابتدا نسبت به ثبت نام در دوره پیش نیاز  <a href="'.
                            Router::url('/lms/detail/'.$related['lms_course_ids']).
                            '" class="btn btn-sm btn-primary">'.
                            (isset($related['lms_courses']['title'])?$related['lms_courses']['title']:'').
                            '</a> اقدام نموده و سپس دوباره تلاش کنید');
                        $related = false;
                }
                elseif(count($relateds) == 1 and 
                    $relateds[0]['created']->format('Y-m-d H:i:s')> $time->format('Y-m-d H:i:s') ){
                    $this->Flash->error($this->setting['course_related_limit_alert']);
                    $related = false;
                }
                elseif( ($fact = $this->LmsUserfactors->find('all')
                    ->where([
                        'user_id'=>$this->request->getAttribute('identity')->get('id'),
                        'lms_course_id'=>$related['lms_course_ids'] ,
                        'enable'=>0
                    ])
                    ->first()) ){
                        $this->Flash->error('شما هنوز فاکتور دوره پیش نیاز  را پرداخت نکرده اید.
                         ابتدا نسبت به <a href="'.
                            Router::url('/lms/client/factors?id='.$fact['lms_factor_id']).
                            '" class="btn btn-sm btn-primary">پرداخت فاکتور</a> اقدام نموده و سپس دوباره تلاش کنید');
                        $related = false;
                }
            }
            /* var_dump($related);
            return false; */

            if($related != true){
                return $this->redirect($this->referer());
            }
        }

        if ($this->request->is('post')) {
            $lmsFactor = $this->LmsFactors->newEntity();
            $lmsFactor = $this->LmsFactors->patchEntity($lmsFactor,[
                    'user_id'=>$this->request->getAttribute('identity')->get('id'),
                    'price'=>$lmsCourses['price'],
                    'paid'=>0,
                    'status'=>0,
                    'descr'=>'ثبت نام در '. $lmsCourses['title'] ,
                ]);
            if ($id = $this->LmsFactors->save($lmsFactor)) {
                $lmsuserf = $this->LmsUserfactors->newEntity();
                $lmsuserf = $this->LmsUserfactors->patchEntity($lmsuserf,[
                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                        'lms_factor_id' => $lmsFactor->id,
                        'lms_course_id' => $lmsCourses['id'],
                        'enable' => 0,
                    ]);
                if ($this->LmsUserfactors->save($lmsuserf)) {

                    // از اینجا منتقل شد به پس از پرداخت فاکتور
                    // 1401-12-01
                    /* $lmsCourseuser = $this->LmsCourseusers->newEntity();
                    $lmsCourseuser = $this->LmsCourseusers->patchEntity($lmsCourseuser, [
                        'user_id' => $this->request->getAttribute('identity')->get('id'),
                        'lms_course_id' => $lmsCourses['id']
                    ]);
                    $this->LmsCourseusers->save($lmsCourseuser); */

                    $this->Flash->success('
                        ثبت فاکتور شماره #'.$lmsFactor->id.' با موفقیت انجام شد. '.
                        '<br>جهت فعال شدن دوره، از طریق دکمه زیر، اقدام به پرداخت فاکتور نمایید.'
                         //<br><a href="'.Router::url('/lms/client/factors?id='.$lmsFactor->id).'" class="btn btn-sm btn-primary">نمایش فاکتور</a>
                    );
                   return $this->redirect('/lms/client/factors?id='.$lmsFactor->id);
                }
                else{
                    $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد12 ');
                    return $this->redirect($this->referer());
                }
            }else{
                $this->Flash->error('متاسفانه ثبت فاکتور انجام نشد - کد11 ');
                return $this->redirect($this->referer());
            }

        }
        /* $lmsFactor = $this->LmsFactors->patchEntity();
        
            $lmsFactor = $this->LmsFactors->patchEntity($lmsFactor, $this->request->getData());
            if ($this->LmsFactors->save($lmsFactor)) {
                $this->Flash->success(__('The lms factor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lms factor could not be saved. Please, try again.'));
        } */

        $this->render(false);

    }
    //----------------------------------------------------------------
}