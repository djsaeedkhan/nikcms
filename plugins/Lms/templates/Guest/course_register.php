<?php
use Lms\View\Helper\LmsHelper;
$lmsCourse =$results;
$option = [];
if($lmsCourse['options'] != ""){
    $option = json_decode($lmsCourse['options'],true);
}
?>
<div class="guest_detail">
    <div class="row">
        <div class="col-sm-3 mb-2">
            <?= $lmsCourse['image'] !=''?$this->html->image($lmsCourse['image'],['style'=>'width:100%;max-height:100%;']).'<br><br>':''?>

            <?= (array_search('course_file', $option['roles']) !== NULL)?$this->Html->link(__('لیست دروس'), 
                '/lms/view/'. $lmsCourse['id'].'/'.$lmsCourse['title'],
                ['class'=>'btn btn-sm btn-secondary mb-2'] ):'' ?>

            <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
                '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                ['class'=>'btn btn-sm btn-secondary mb-2'] ):'' ?>
        </div>

        <div class="col-sm-5 mb-2">
            
            
            <div class="card"><div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5> دوره: <strong><?= h($lmsCourse['title']) ?></strong></h5>
                    </div>

                    <?php if(array_search('price', $option['roles']) !== NULL):?>
                    <div class="col-sm-6">
                        مبلغ : <?=LmsHelper::PriceShow($lmsCourse->price) .$lmsCourse->sprice?>
                    </div>
                    <?php endif?>

                    <div class="col-sm-12"></div>
                    <div class="col-sm-6"></div>
                </div>
            </div></div>
            <br>
            <?= (array_search('register', $option['roles']) !== NULL)?$this->Form->postlink(
                __('ثبت نام دوره'),
                '/lms/subscribe/'.$lmsCourse['id'],
                ['class'=>'btn btn-success','confirm'=>'برای ثبت نام در این دوره مطمئن هستید؟']):'' ?>
        </div>


        <div class="col-sm-4 mb-2">
            <?php include_once('part-dashboard.php') ?>
        </div>
    
    </div>
</div>