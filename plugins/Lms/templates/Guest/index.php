<?php use Lms\View\Helper\LmsHelper;?>
<?php $this->assign('title','لیست دوره ها')?>
<h2 class="px-3 my-2">لیست دوره ها</h2>
<div class="guest_index col-12 ">
    <div class="row">
<?php 
foreach ($lmsCourses as $lmsCourse):
    
    $option = [];
    if($lmsCourse['options'] != ""){
        $option = json_decode($lmsCourse['options'],true);
    }
    ?>
    <div class="col-sm-4 mb-4"><div style="border: 1px solid #f8d96a;padding: 5px;border-radius: 10px;">
        <?php
        if($lmsCourse['image'] !=''){
            try {
                $img = explode('/',$lmsCourse['image']);
                $img = $img[count($img) - 1];
                echo $this->html->image(
                    '/users/thumbnail/'.$img.'/500/500',
                    ['class'=>'','style'=>'width:100%;max-height: 210px;']).'<br><br>';
            } catch (\Throwable $th) {
                echo $this->html->image($lmsCourse['image'],
                ['class'=>'','style'=>'width:100%;max-height: 210px;']).'<br><br>';
            }
        }?>
        
        <div class="text-center">
            <div class="mb-3" style="font-size: 16px;letter-spacing: -0.3px;">
                <strong><?= h($lmsCourse['title']) ?></strong>
            </div>

            <div class="mb-3 px-3">
                <?= nl2br($lmsCourse['text'])?>
            </div>

            <?php if(array_search('price', $option['roles']) !== NULL):?>
                <div class="mb-3">
                    <strong><?= $lmsCourse->price !== null?
                        '<div>مبلغ دوره: '.($lmsCourse->price!=0?
                        $lmsCourse->sprice. LmsHelper::PriceShow($lmsCourse->price) 
                            :'رایگان') .'</div>':''?>
                    </strong>
                </div>
            <?php endif?>

            <div class="mb-3">
                <?php include('part-dashboard.php') ?>
            </div>

            <div class="text-sm-left text-center pt-2" style="display: flex;justify-content: center;">
                <?= (array_search('descr', $option['roles']) !== NULL)?$this->Html->link(__('نمایش توضیحات'), 
                    '/lms/detail/'. $lmsCourse['id'].'/'.$lmsCourse['slug'],
                    ['class'=>'btn btn-sm btn-secondary mb-2','style'=>'font-size: 12px;'] ):'' ?>
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

    </div></div>

<?php endforeach; ?>

</div>

<style>
    .caart .btn{
        cursor: pointer;
        font-size: 13px;
    }
    @media screen and (max-width: 600px) {
        .btn-secondary {
            width: 47%;
        }
    }
</style>