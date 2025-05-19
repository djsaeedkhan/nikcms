<?php
namespace Lms;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Checker
{
    function __construct() {}
    public function checkcurrent($course_id = null, $file_id = null , $user_id = null , $query = null){
        $status = "true";
        $coursefile = TableRegistry::get('Lms.LmsCoursefiles')->find('all')
            ->where(['id' => $file_id])
            ->first(); 
        
        $courseuser = TableRegistry::get('Lms.LmsCourseusers')->find('all')
            ->contain(['LmsCourses'])
            ->where(['LmsCourseusers.user_id' =>  $user_id , 'lms_course_id' => $course_id])
            ->first();

        if(! $courseuser){
            $status = "link";
            /* pr("e1"); */
        }
        else{
            $filecans = TableRegistry::get('Lms.LmsCoursefilecans');
            $coursefilecan = $filecans->find('all')
                ->where(['user_id' =>  $user_id , 'lms_coursefile_id' => $file_id ])
                ->first();
            
            //if(isset($courseuser['lms_course']['date_start']) and $courseuser['lms_course']['date_start'] !='')
            if($courseuser['lms_course']['date_type'] == 2)
                $time = new Time( $courseuser['lms_course']['date_start'] );
            else
                $time = new Time($courseuser['created']);

            $time->addDays($coursefile['days']);

            $coursefilecan = $filecans->find('all')
                ->where(['user_id' =>  $user_id , 'lms_coursefile_id' => $file_id ])
                ->first();
    
            if(! $coursefilecan ){

                if(isset($query['file']) and $query['file'] == $file_id){
                    $exam = TableRegistry::get('Lms.LmsCourseexams')->find('all')
                        ->where(['lms_coursefile_id' =>  $file_id])
                        ->first();
                    if($exam){
                        $result = TableRegistry::get('Lms.LmsExamresults')->find('all')
                            ->where(['user_id' =>  $user_id , 'lms_coursefile_id'=>$file_id, 'lms_exam_id' => $exam['lms_exam_id'] , 'result' => 2 ])
                            ->first();
                        if($result){
                            if(Time::now() > $time){
                                $this->enablefile($user_id , $file_id);
                                $status = "true";
                            }
                            else{ $status = "link";/* pr("e2"); */}
                        }
                        else {$status = "link";/* pr("e3"); */}
                    }
                    else{
                        if(Time::now() > $time){
                            $this->enablefile($user_id , $file_id);
                            $status = "true";
                        }
                        else {$status = "link";pr("e4");}
                    }
                }
                else {$status = "link";/* pr("e5"); */}
            }
            else $status = "true";
        }
        return $status;
    }
    //-------------------------------------------------------------------------------
    public function checkIS($course_id = null, $file_id = null , $user_id = null , $query = null){
        $status = true;
        $coursefile = TableRegistry::get('Lms.LmsCoursefiles')->find('all')
            ->where(['id' => $file_id])
            ->first(); 

        if(! $file_id)
            return false;
        
        $courseuser = TableRegistry::get('Lms.LmsCourseusers')->find('all')
            ->contain(['LmsCourses'])
            ->where(['LmsCourseusers.user_id' =>  $user_id , 'lms_course_id' => $course_id])
            ->first();

        $fcan = TableRegistry::get('Lms.LmsCoursefilecans')
            ->find('all')
            ->where([
                'LmsCoursefilecans.user_id'=>$user_id , 
                'lms_course_id'=> $course_id, 
                'types'=>1,
                'lms_coursefile_id'=> $file_id,
                ])
            ->first();

        if(! $courseuser){
            $status = true;
        }
        elseif($fcan ){
            $status = true;
        }
        else{
            //if(isset($courseuser['lms_course']['date_start']) and $courseuser['lms_course']['date_start'] !=''){
            if($courseuser['lms_course']['date_type'] == 2){
                $time = new Time( $courseuser['lms_course']['date_start'] );
            }
            else{
                $time = new Time($courseuser['created']);
            }
            $time->addDays($coursefile['days']);
            if(isset($query['file']) and $query['file'] == $file_id){
                $exam = TableRegistry::get('Lms.LmsCourseexams')->find('all')
                    ->where(['lms_coursefile_id' =>  $file_id])
                    ->first();
                if($exam){

                    if(TableRegistry::get('Lms.LmsExamresults')->find('all')
                        ->where(['user_id' =>  $user_id ,  'lms_coursefile_id'=>$file_id,'lms_exam_id' => $exam['lms_exam_id']])->count() > 0 )
                    {
                        $result = TableRegistry::get('Lms.LmsExamresults')->find('all')
                            ->where(['user_id' =>  $user_id , 'lms_coursefile_id'=>$file_id, 'lms_exam_id' => $exam['lms_exam_id'] , 'result !=' => 2  ])
                            ->toarray();

                        $exams = TableRegistry::get('Lms.LmsExams')->get($exam['lms_exam_id']);
                        if( count($result) >= $exams['reexam']){
                            $status = false; 
                        }
                        else{
                            $status = true; 
                            /* $result = TableRegistry::get('Lms.LmsExamresults')->find('all')
                                ->where(['user_id' =>  $user_id , 'lms_coursefile_id'=>$file_id, 'lms_exam_id' => $exam['lms_exam_id'] , 'result' => 2  ])
                                ->first();
                            if($result){
                                $status = true;
                                if(Time::now()->format('Y-m-d') >= $time->format('Y-m-d')){
                                    $status = true;
                                }
                                else{
                                    $status = false; 
                                }
                            }
                            else{
                                $status = false; 
                            } */
                        }
                    }
                    else{
                        $status = true;
                    }
                }
                else{
                    if(Time::now()->format('Y-m-d') >= $time->format('Y-m-d')){
                        $status = true;
                    }
                    else $status = false;
                }
            }
            else $status = false;
        }
        return $status;
    }
    //-------------------------------------------------------------------------------
    public function find_next($file_id = null){
        $LmsCoursefiles = TableRegistry::get('Lms.LmsCoursefiles');
        $file = $LmsCoursefiles->find('all')
            ->where(['id' => $file_id ])
            ->first();
        $res = null;
        if($file){
            $weeks = $LmsCoursefiles
                ->find('list',['keyField'=>'id'])
                ->order(['priority'=>'asc'])
                ->where(['lms_course_id' => $file['lms_course_id'] ])
                ->toarray();
            $weeks = array_values( $weeks );

            for($i=0;$i<count($weeks);$i++){
                if($weeks[$i] == $file_id ){
                    break;
                }
            }
            $i++;
            if(isset($weeks[$i])){
                $res = $weeks[$i];
            }
            else{
                $res = false;
            }
        }else{
            $res = false;
        }
        return $res ;
    }
    //-------------------------------------------------------------------------------
    public function enablefile($user_id = null, $file_id = null ){
        $course_id = TableRegistry::get('Lms.LmsCoursefiles')
            ->find('all')
            ->where(['id'=>$file_id])
            ->first();

        if(! $course_id) 
            return 0;
        $course_id = $course_id['lms_course_id'];

        $fcan = TableRegistry::get('Lms.LmsCoursefilecans')
            ->find('all')
            ->where(['user_id'=>$user_id , 'lms_course_id'=> $course_id ])
            ->order(['id'=>'desc'])
            ->first();
        if(! $fcan) 
            return $this->_enablefiles($user_id,$file_id,$course_id);

        $fexist = TableRegistry::get('Lms.LmsCoursefilecans')
            ->find('all')
            ->where(['user_id'=>$user_id , 'lms_course_id'=> $course_id , 'lms_coursefile_id'=>$file_id ])
            ->first();
        if($fexist)
            return 1;

        $time = new Time($fcan['created']);
        $time->addMinute(1);
        if( Time::now()->format('Y-m-d H:i') >= $time->format('Y-m-d H:i') ){
            return $this->_enablefiles($user_id,$file_id,$course_id);
        }
        else
            return "time_not_come";
    }
    //-------------------------------------------------------------------------------
    private function _enablefiles($user_id = null, $file_id = null, $course_id = null ){
        $filecans = TableRegistry::get('Lms.LmsCoursefilecans');
        $lmsCoursefile = $filecans->newEntity();
        $lmsCoursefile = $filecans->patchEntity($lmsCoursefile, [
            'user_id' =>  $user_id,
            'lms_coursefile_id' => $file_id , 
            'lms_course_id' => $course_id , 
            'types'=>0,
            'enable' => 1
        ]);
        if($filecans->save($lmsCoursefile)){
            return 1;
        }
        else{
            return 0;
        }
    }
    //-------------------------------------------------------------------------------
    public function CheckUsercourseExpire($lmsCourse = null ,$lmsCourseuser = null ){
        if( $lmsCourse['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
            $time = new Time( $lmsCourse['date_end']->format('Y-m-d') );
        }
        else{ //تاریخ ثبت دوره برای کاربر

            //https://www.php.net/manual/en/dateinterval.format.php
            $interval = date_diff(
                date_create($lmsCourse['date_start']->format('Y-m-d')),
                date_create($lmsCourse['date_end']->format('Y-m-d')) );
            $origin = $interval->format('%R%a');
            $day = (intval($origin));

            $time = new Time($lmsCourseuser['created']);
            if($day > 0){
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                //$day -= 1;
                $time->addDays($day);
            }
            $time = $time->format('Y-m-d');
        }

        if( Time::now()->format('Y-m-d') < $time){
            $interval = date_diff(
                date_create(Time::now()->format('Y-m-d')),
                date_create($time) );
            return $interval;
        }
        else{
            return false;
        }
    }
    //-------------------------------------------------------------------------------
    public function GetCourseuser_StartDate($lmsCourse = null ,$lmsCourseuser = null ){
        if( $lmsCourse['date_type'] == 2 ){ //تاریخ شروع مشخص شده برای دوره
            $time = new Time( $lmsCourse['date_end']->format('Y-m-d') );
        }
        else{ //تاریخ ثبت دوره برای کاربر

            //https://www.php.net/manual/en/dateinterval.format.php
            $interval = date_diff(
                date_create($lmsCourse['date_start']->format('Y-m-d')),
                date_create($lmsCourse['date_end']->format('Y-m-d')) );
            $origin = $interval->format('%R%a');
            $day = (intval($origin));

            $time = new Time($lmsCourseuser['created']);
            if($day > 0){
                $time->setTimezone(new \DateTimeZone('Asia/Tehran'));
                $day -= 2;
                $time->addDays($day);
            }
            $time = $time->format('Y-m-d');
        }

        $interval = date_diff(
            date_create(Time::now()->format('Y-m-d')),
            date_create($time) );
        return ($interval->days);
    }
    //-------------------------------------------------------------------------------
    public function PrintTime($interval = null ){

        echo $interval->format('%y')!=0? 
                $interval->format('%y سال ') .( intval($interval->format('%m')) > 0?' و ':''):'';
        echo $interval->format('%m')!=0? 
            $interval->format('%m ماه ') .( intval($interval->format('%d')) > 0?' و ':''):'';
        echo  intval($interval->format('%d')) > 0?$interval->format('%d روز'):'';
    }

}