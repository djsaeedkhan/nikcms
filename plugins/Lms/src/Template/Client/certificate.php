<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    درخواست گواهینامه دوره: 
                </h2>
                <div style="padding: 5px;">&nbsp;&nbsp;<?=$lmsCourses['title']?></div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
<?php
if(count($history) > 0){
    echo '<div class="alert alert-primary">شما قبلا درخواست گواهینامه صادرکرده اید.</div>';

    if($history[0]['enable'] == 0){
        echo $this->html->link("دانلود فایل گواهینامه",$history[0]['download'],['class'=>'btn btn-primary']);
    }
    else{
        echo 'درخواست شما در حال بررسی می باشد. لطفا منتظر پاسخ درخواست بمانید';
    }
}
else{
    echo $this->Form->create($lmsCertificate,['class'=>'col-sm-6']) ?>

        <?= $this->Form->control('data.father_name',['label'=>'نام پدر','class'=>'form-control']);?>
        <br>
        <?= $this->Form->control('data.codemeli',['label'=>'کدملی','class'=>'form-control']);?>

    <br>
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?php echo $this->Form->end() ;
}
?>
</div></div>