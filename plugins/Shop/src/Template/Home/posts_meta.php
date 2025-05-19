<?php
$path = $this->request->getAttribute("webroot") . $upload_path;
?>

<?= $this->Form->create($post,[
    //'url'=>['plugin'=>'Admin','controller'=>'Posts','action'=>'edit'],
    'id' => 'myform','class'=>'post_page']) ?>

<?= $this->Form->button(__('Submit'),[
    'class'=>'mt-1 mb-1 btn btn-success',
    'style'=>'position: absolute;z-index: 9999;left: 40px;']);?>

<?php
if(count(@$navmenu = $this->Func->admin_postwidget($post_types))):
    foreach($navmenu as $nav){
        foreach($nav as $knav=>$vnav)
            echo $this->cell($vnav,[$knav,isset($post_meta_list)?$post_meta_list:[]]);
    }
endif;
?>
<?= $this->Form->end() ?>
<?php $this->start('modal');?>
    <?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>