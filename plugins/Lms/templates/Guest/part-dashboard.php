<?php if(array_search('course_time', $option['roles']) !== NULL):?>
    <div class="alert alert-warning mb-1">
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
            <b>مدت زمان دسترسی:</b>
            <?php
            //https://www.php.net/manual/en/dateinterval.format.php
            $interval = date_diff(
                date_create($lmsCourse['date_start']->format('Y-m-d')),
                date_create($lmsCourse['date_end']->format('Y-m-d')) );

            echo $interval->format('%y') != 0? 
                $interval->format('%y سال ') .( intval($interval->format('%m')) > 0?' و ':''):'';
            echo $interval->format('%m') != 0? 
                $interval->format('%m ماه ') .( intval($interval->format('%d')) > 0?' و ':''):'';
            echo  intval($interval->format('%d')) > 0?$interval->format('%d روز'):'';
            ?>
        <?php endif?>
    </div>
<?php endif?>

<?php if(array_search('course_related', $option['roles']) !== NULL):?>
    <?php if(isset($lmsCourse['lms_courserelateds'][0]) ):?>
        <div class="alert alert-warning">
            <div class="pb-2"><strong class="pb-2">دوره های پیش نیاز: </strong></div>

            <?php foreach($lmsCourse['lms_courserelateds'] as $related):?>
            <li>
                <?= isset($related['lms_courses']['title'])?$related['lms_courses']['title']:'نامشخص'; ?>
            </li>
            <?php endforeach;?>
        </div>
    <?php endif?>
<?php endif?>

<?php if(array_search('course_gam', $option['roles']) !== NULL):?>
    <div class="alert alert-warning mb-1"> دوره دارای 
        <span class="badge badge-warning badge-pill">
            <?= count($lmsCourse['lms_courseweeks'])?>
        </span> بخش
        و
        <span class="badge badge-warning badge-pill">
            <?php // isset($lmsCoursefiles[$lmsCourse['id']])?count($lmsCoursefiles[$lmsCourse['id']]):'0'?>
            <?php
            $count = 0;
            if(is_array($lmsCourse['lms_courseweeks'])){
                foreach($lmsCourse['lms_courseweeks'] as $week){
                    if(isset($week['lms_coursefiles']) and is_array($week['lms_coursefiles']))
                        $count += count($week['lms_coursefiles']);
                }
            }
            echo $count;?>
        </span> جلسه 
        می باشد.
    </div>
<?php endif?>

<?php if(array_search('total_time', $option['roles']) !== NULL and $lmsCourse['total_time'] != ""):?>
    <div class="alert alert-warning mb-1">
        مجموع ساعات دوره 
        <span class="badge badge-warning badge-pill"><?= $lmsCourse['total_time']?></span> 
        می باشد
    </div>
<?php endif?>



<!-- <div class="mb-1">- در این دوره شما
    <span class="badge badge-warning badge-pill">
        <?php // isset($lmsCourseexam[$lmsCourse['id']])?count($lmsCourseexam[$lmsCourse['id']]):'0'?>
    </span>
    آزمون انجام خواهید داد.
</div> -->