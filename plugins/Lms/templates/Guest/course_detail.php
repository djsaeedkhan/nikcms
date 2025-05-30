<?php $lmsCourse =$results;
$option = [];
if($lmsCourse['options'] != ""){
    $option = json_decode($lmsCourse['options'],true);
}
?>
<div class="guest_detail">
    <div class="row">
        <div class="col-sm-3">
            <?= $lmsCourse['image'] !=''?$this->html->image($lmsCourse['image'],['style'=>'width:100%;max-height:100%;']).'<br><br>':''?>

            <div class="d-none d-sm-block">
                <!-- <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
                    '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                    ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?> -->

                &nbsp;
                <?= (array_search('course_file', $option['roles']) !== NULL)?$this->Html->link(__('لیست دروس'), 
                    '/lms/view/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                    ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?>

                &nbsp;
                <?= (array_search('register', $option['roles']) !== NULL)?$this->Form->postlink(
                    __('ثبت نام دوره'),
                    '/lms/subscribe/'.$lmsCourse['id'].'/'.$lmsCourse['slug'],
                    [
                        'class'=>'btn btn-sm btn-success d-block d-md-inline-block mb-2',
                        'style'=>'font-size: 12px;'
                        //'confirm'=>'برای ثبت نام در این دوره مطمئن هستید؟'
                    ]):'';?>
            </div>

        </div>

        <div class="col-sm-9">
            <h5 style="font-size: 17px;"> دوره: <strong><?= h($lmsCourse['title']) ?></strong></h5>
            <p class="text-justify">
                <?= nl2br($lmsCourse['textweb'])?>
            </p>

            <div class="d-block d-sm-none">
                <!-- <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
                    '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                    ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?> -->

                &nbsp;
                <?= (array_search('course_file', $option['roles']) !== NULL)?$this->Html->link(__('لیست دروس'), 
                    '/lms/view/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                    ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?>

                &nbsp;
                <?= (array_search('register', $option['roles']) !== NULL)?$this->Form->postlink(
                    __('ثبت نام دوره'),
                    '/lms/subscribe/'.$lmsCourse['id'].'/'.$lmsCourse['slug'],
                    [
                        'class'=>'btn btn-sm btn-success d-block d-md-inline-block mb-2',
                        'style'=>'font-size: 12px;'
                        //'confirm'=>'برای ثبت نام در این دوره مطمئن هستید؟'
                    ]):'';?>
            </div>

        </div>
    </div>
</div>