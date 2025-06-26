<?php use Lms\View\Helper\LmsHelper;?>
<?php $this->assign('title','دسته بندی دوره ها')?>
<h2 class="px-3 my-2">دسته بندی دوره ها</h2>
<div class="guest_index col-12 ">
    <div class="row" style="justify-content: center;">

<?php foreach ($lmsCourseCategories as $cat): ?>
   
    <div class="col-sm-4 mb-4"><div style="border: 1px solid #f8d96a;padding: 5px;border-radius: 10px;">
        <?php
        if($cat['image'] !=''){
            echo $this->html->image(
                $cat['image'],
                ['class'=>'','style'=>'width:100%;max-height: 210px;']).'<br><br>';
        }?>
        
        <div class="text-center">
            <div class="mb-3" style="font-size: 16px;letter-spacing: -0.3px;">
                <strong><?= h($cat['title']) ?></strong>
            </div>

            <div class="mb-3 px-3">
                <?= nl2br($cat['descr']) ?>
            </div>

            <?php for($i=1;$i<4;$i++):if(isset($cat['descr'.$i]) and $cat['descr'.$i] != ""):?>
            <div class="alert alert-warning mb-1">
                <?= $cat['descr'.$i] ?>
            </div>
            <?php endif;endfor?>

            <div class="text-sm-left text-center pt-2" style="display: flex;justify-content: center;">
                <?= $this->html->link(
                    (isset($cat['button']) and $cat['button'] != "")?$cat['button']:'نمایش دوره ها',
                    '/lms/?cat='. $cat['id'],
                    ['class'=>'btn btn-sm btn-secondary mb-2']);?>

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