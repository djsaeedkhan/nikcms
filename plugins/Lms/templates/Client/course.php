<?php 
use Lms\Checker;
use Lms\View\Helper\LmsHelper;
$checker = new Checker();
?>
<div class="client_index">
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    دوره های من
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none"></div>
</div>

<?php
foreach ($lmsCourses as $lmsCourseuser):
    $lmsCourse = $lmsCourseuser['lms_course'];
    $expire = $checker->CheckUsercourseExpire($lmsCourse, $lmsCourseuser);
    $options = isset($lmsCourse['options'])?json_decode($lmsCourse['options'], true):[];
    ?>
    <div class="card caart">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <?php if(isset($lmsCourse['image']) and $lmsCourse['image'] !=''){
                        $img = explode('/',$lmsCourse['image']);
                        $img = $img[count($img) - 1];
                        echo $this->html->image('/users/thumbnail/'.$img.'/500/400',
                        ['style'=>'width:100%;max-height:100%;']).'<br><br>';
                    }
                    ?>
                </div>
                <div class="col-sm-7">
                    
                    <h5> دوره: <strong><?= isset($lmsCourse['title'])?h($lmsCourse['title']):"-" ?></strong></h5>

                    <?php if(isset($lmsCourse['date_type'])):?>
                        <div class="alert alert-secondary mb-1">
                            <?php if($lmsCourse['date_type'] == 2):?>
                            <div>
                                <b>تاریخ شروع : </b>
                                <?= $lmsCourse['date_start']!= '' ?$this->Func->date2($lmsCourse['date_start'],'Y-m-d'):' بدون محدودیت'; ?>
                            </div>
                            <div>
                                <b>تاریخ پایان: </b>
                                <?= $lmsCourse['date_end']!= '' ?$this->Func->date2($lmsCourse['date_end'],'Y-m-d'):'بدون محدودیت' ?>
                            </div>
                            <?php else:?>
                                <b>مدت دوره:</b>
                                <?php
                                if(isset($lmsCourse['date_start'])){
                                    //https://www.php.net/manual/en/dateinterval.format.php
                                    $interval = date_diff(
                                        date_create($lmsCourse['date_start']->format('Y-m-d')),
                                        date_create($lmsCourse['date_end']->format('Y-m-d')) );
                                    
                                    echo $interval->format('%y') !=0 ? 
                                        $interval->format('%y سال ') .( intval($interval->format('%m')) > 0?' و ':''):'';
                                    echo $interval->format('%m') !=0 ? 
                                        $interval->format('%m ماه ') .( intval($interval->format('%d')) > 0?' و ':''):'';
                                    echo  intval($interval->format('%d')) > 0?$interval->format('%d روز'):'';
                                }
                                ?>
                                <hr>
                                <b>زمان باقیمانده شما: </b>

                                <?php 
                                if($expire != false)
                                    echo $checker->PrintTime($expire);
                                else
                                    echo  "منقضی شده";
                                ?>
                            <?php endif?>
                        </div>
                    <?php endif?>
                        
                    <?php if(isset($lmsCourse['lms_courserelateds'][0]) ):?>
                        <div class="alert alert-primary">
                            <div class="pb-2"><strong class="pb-2">دوره های پیش نیاز: </strong></div>

                            <?php foreach($lmsCourse['lms_courserelateds'] as $related):?>
                            <li>
                                <?= isset($related['lms_courses']['title'])?$related['lms_courses']['title']:'نامشخص'; ?>
                            </li>
                            <?php endforeach;?>
                        </div>
                    <?php endif?>

                    <div class="mb-1">- دوره دارای 
                        <span class="badge badge-light-primary badge-pill">
                            <?= (isset($lmsCourse['lms_courseweeks']) and is_array($lmsCourse['lms_courseweeks']))?count($lmsCourse['lms_courseweeks']):'-'?>
                        </span> بخش
                        و
                        <span class="badge badge-light-primary badge-pill">
                            <?php
                                $count = 0;
                                if(isset($lmsCourse['lms_courseweeks']) and is_array($lmsCourse['lms_courseweeks'])){
                                    foreach($lmsCourse['lms_courseweeks'] as $week){
                                        if(isset($week['lms_coursefiles']) and is_array($week['lms_coursefiles']))
                                            $count += count($week['lms_coursefiles']);
                                    }
                                }
                                echo $count;?>
                        </span> جلسه 
                        می باشد.
                    </div>

                    <?php
                    $exam = (isset($lmsCourse['id']) and isset($lmsCourseexam[$lmsCourse['id']]))?count($lmsCourseexam[$lmsCourse['id']]):0;
                    if($exam > 0):?>
                        <div class="mb-1">- در این دوره شما
                            <span class="badge badge-light-primary badge-pill">
                                <?= $exam;?>
                            </span>
                            آزمون انجام خواهید داد.
                        </div>
                    <?php endif?>

                        <!-- <br>وضعیت:  -->
                    <?php
                    if(isset($lmsCourse['id'])):
                        if(isset($lmsCoursefilecan[$lmsCourse['id']]) and count($lmsCoursefilecan[$lmsCourse['id']]) == 0)
                            echo '<div class="mb-1"> - شما هنوز هیچ جلسه ای را مشاهده نکرده اید.</div>';
                            
                        if(isset($lmsCoursefilecan[$lmsCourse['id']]) and count($lmsCoursefilecan[$lmsCourse['id']]) > 0){
                            echo '<div class="mb-1"> - شما <span class="badge badge-light-primary badge-pill">';
                                $cnt = count($lmsCoursefilecan[$lmsCourse['id']]);
                            if($cnt == 0) echo "0";
                            else echo ($cnt - 1);
                            echo '</span> گام از دوره را طی کرده اید.</div>';
                        }
                    endif;
                    ?>
                </div>
            </div>

            <?php
            if(
                isset($options['unlimit_access']) and $options['unlimit_access'] == 1 and 
                $lmsCourseuser['enable'] == 0 
            ):
                echo $this->Html->link(__('ورود دائمی به دوره'), 
                    '/lms/client/courses/'. $lmsCourse['id'],
                    ['class'=>'float-left btn btn-success'] );

            elseif($lmsCourseuser['enable'] == 1 and $expire != false):
                echo $this->Html->link(__('ورود به دوره'), 
                    '/lms/client/courses/'. $lmsCourse['id'],
                    ['class'=>'float-left btn btn-success'] );  
 
            else:
                if($expire != false){
                    echo $this->Html->link(__('ورود به دوره'), 
                        '/lms/client/courses/'. $lmsCourse['id'],
                        ['class'=>'float-left btn btn-success'] );
                }else{
                    echo '<span class="float-left btn btn-secondary fw-n">دوره به پایان رسیده است</span>';
                }
                # echo  $this->Html->link(__('درخواست گواهینامه'), 
                #    '/lms/client/certificate/'. $lmsCourse['id'],[
                #        //'confirm'=>'',
                #        'class'=>'float-left btn btn-success mx-1'] );
            endif;

            if( (isset($expire) and $expire == false) and (isset($lmsCourse['can_renew']) and $lmsCourse['can_renew'] == 1) ){
                if($lmsCourse['renew_day'] != "" and $lmsCourse['price_renew'] != ""){
                    echo $this->Html->link(__('تمدید دوره'), 
                        '/lms/client/renew/'. $lmsCourse['id'],
                        [
                            'confirm'=>'آیا موافق هستید که این دوره با مدت دسترسی  '.
                            $lmsCourse['renew_day'].' روز و مبلغ '.
                            strip_tags(LmsHelper::PriceShow($lmsCourse['price_renew'])).' برای شما تمدیدگردد؟',
                            'class'=>'float-left btn btn-warning mx-1'] );
                }
                else{?>
                    <div class="btn-group float-left">
                        <a class=" btn btn-warning mx-1" style="border-radius:5px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= __('تمدید دوره')?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php
                            $renew = $options['renew'];
                            foreach([1,2,3,6,12] as $month):
                                if(isset($renew[$month.'m_title']) and $renew[$month.'m_title'] != ""){
                                    $price = strip_tags(LmsHelper::PriceShow($renew[$month.'m_price']));
                                    echo $this->Form->postlink(
                                        $renew[$month.'m_title'].' ('.$price.')',
                                        '/lms/client/renew/'. $lmsCourse['id'].'/'.$month,[
                                        'confirm'=>"آیا موافق هستید که این دوره با مدت دسترسی  ". $renew[$month.'m_title']." و مبلغ $price برای شما تمدیدگردد؟",
                                        'class'=>'dropdown-item']);
                                }
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php 
                    /* echo $this->Html->link(__('تمدید د2وره'), 
                        '/lms/client/renew/'. $lmsCourse['id'],
                        [
                            'confirm'=>'آیا موافق هستید که این دوره با مدت دسترسی  '.
                            $lmsCourse['renew_day'].' روز و مبلغ '.
                            strip_tags(LmsHelper::PriceShow($lmsCourse['price_renew'])).' برای شما تمدیدگردد؟',
                            'class'=>'float-left btn btn-warning mx-1'] ); */
                }
                
            }?>
        </div>
    </div>
<?php endforeach; ?>
</div>