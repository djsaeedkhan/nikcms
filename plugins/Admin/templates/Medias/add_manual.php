<?php
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
$path = $this->request->getAttribute("webroot") . $upload_path;?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= (isset($comment['id'])?__d('Admin', 'ویرایش رسانه'):__d('Admin', 'آپلود دستی رسانه'))?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'file','class'=>'col-sm-6']);?>
        <?= $this->Form->control('file', [
            'type' => 'file',
            'id'=>'FilUploader',
            'label'=>false,'required',
            'class' => 'form-control']);?>
            <bR>
        <?= $this->Form->control(
            __d('Admin', 'شروع آپلود'), [
            'type' => 'submit',
            'class' => 'btn btn-success btn-sm',
            'label'=>false,
            ]);?>
        <?= $this->Form->end(); ?>
    </div>

    <?php if(isset($filename)):?>
        <div class="col-sm-12"><div class="alert alert-success mb-1">
            <img class="card-img-top rounded" style="background:#FFF;width:40px;height:40px;"
                src="<?=$path?><?=$filename?>" data-holder-rendered="true">
            <?=$filename?>
            <a target="_blank" href="<?=$path?><?=$filename?>" class="pull-left1" style="padding: 5px;">
                [<?=__d('Admin', 'مشاهده فایل')?>]
            </a>
        </div></div>
    <?php endif?>
    
</div>
<script nonce="<?=get_nonce?>">
$(function() {
    $('#FilUploader').change(function() {
        var fileExtension = ['webp','svg','zip','rar','jpg','jpeg','png','gif','pdf','docx','doc','xls','xlsx','mp4','mp3'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("<?=__d('Admin', 'فایل آپلودی دارای پسوند غیرمجاز می باشد و آپلود نخواهد شد')?>");
        }
    });
})
</script>