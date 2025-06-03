<?php
use Challenge\Predata;
$predata = new Predata();?>

<?= $this->Form->create($challenge,['class'=>'col-sm-12']) ?>
<legend>مدیریت <?= __d('Template', 'همیاری'); ?></legend>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-10">
                <?php  echo $this->Form->control('title',[
                    'label'=>'عنوان',
                    'class'=>'form-control mb-2']);?>
            </div>
            <div class="col-sm-2">
                <?php  echo $this->Form->control('priority',[
                    'label'=>'اولویت',
                    'class'=>'form-control mb-2']);?>
            </div>
        </div>
        <?php
       

        echo $this->Form->control('slug',[
            'label'=>'نامک (استفاده در URL)',
            'class'=>'form-control mb-2 ltr']);

        echo $this->Form->control('descr',[
            'label'=>'توضیحات مختصر (در صفحه لیست)',
            'class'=>'form-control mb-2',
            'type'=>'textarea']);

        echo $this->Form->control('price',[
            'label'=>'میزان جایزه',
            'class'=>'form-control mb-2 ltr']);

        echo $this->Form->control('img', [
            'label'=>'تصویر پیشفرض','id'=>'poster',
            'class'=>'form-control mb-2 ltr']);
        echo '<div class="mb-3" style="margin-top: -55px;float: right;margin-right: 10px;">
        <a href="#" data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="انتخاب تصویر" data-dest="poster" style="color:#9e9e9e"><i data-feather="camera"></i></a></div>';
        
        echo $this->Form->control('img1', [
            'label'=>'تصویر پوستر',
            'id'=>'poster1',
            'class'=>'form-control mb-2 ltr']);
        echo '<div class="mb-3" style="margin-top: -55px;float: right;margin-right: 10px;">
        <a href="#" data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="انتخاب تصویر" data-dest="poster1" style="color:#9e9e9e"><i data-feather="camera"></i></a></div>';

        echo $this->Form->control('img2', [
            'label'=>'تصویر پس زمینه',
            'id'=>'poster2',
            'class'=>'form-control mb-2 ltr']);
        echo '<div class="mb-3" style="margin-top: -55px;float: right;margin-right: 10px;">
        <a href="#" data-toggle="modal" data-target="#exampleModal" data-action="select_src" title="انتخاب تصویر" data-dest="poster2" style="color:#9e9e9e"><i data-feather="camera"></i></a></div>';
        ?>

    </div>
    <div class="col-sm-6">
        <?php
        echo $this->Form->control('challengecats._ids', [
            'label'=>__d('Template','سطوح همیاری'). $this->html->link('مدیریت','/admin/challenge/challengecats/',['target'=>'_blank', 'class'=>'badge badge-light-primary']),
            'escape'=>false,
            'options' => $challengecats,
            'class'=>'form-control mb-2 select2']).'<br>';

        echo $this->Form->control('challengetopics._ids', [
            'label'=>'موضوع ها '. $this->html->link('مدیریت','/admin/challenge/challengetopics/',['target'=>'_blank', 'class'=>'badge badge-light-primary']),
            'options' => $challengetopics,
            'escape'=>false,
            'class'=>'form-control select2 mb-2 mt-2'
            ]).'<br>';

        echo $this->Form->control('challengefields._ids', [
            'label'=>'حوزه های ماموریتی'. $this->html->link('مدیریت','/admin/challenge/challengefields/',['target'=>'_blank', 'class'=>'badge badge-light-primary']),
            'escape'=>false,
            'options' => $challengefields,
            'class'=>'form-control select2 mb-2'
            ]).'<br>';
            
        echo $this->Form->control('challengetags._ids', [
            'label'=>'برچسب ها'. $this->html->link('مدیریت','/admin/challenge/challengetags/',['target'=>'_blank', 'class'=>'badge badge-light-primary']),
            'escape'=>false,
            'options' => $challengetags,
            'class'=>'form-control select2 mb-2'
            ]).'<br>';
        ?><hr>

        <div class="row">
            <div class="col-sm-6">
                <?= $this->Form->control('start_date',[
                    'type'=>'text',
                    'class'=>'form-control ltr mb-2',
                    'label'=> 'تاریخ شروع ('.jdate('Y').'/10/10)' ]);?>
            </div>
            <div class="col-sm-6">
                <?=$this->Form->control('end_date',[
                    'type'=>'text',
                    'class'=>'form-control ltr',
                    'label'=> 'تاریخ پایان ('.jdate('Y').'/10/10)']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('challengestatus_id', [
                    'label'=>'وضعیت '. $this->html->link('مدیریت','/admin/challenge/challengestatuses/',['target'=>'_blank', 'class'=>'badge badge-light-primary']),
                    'escape'=>false,
                    'options' => $challengestatuses,
                    'class'=>'form-control mb-2']);?>
            </div>
                
            <div class="col-sm-6">
                <?= $this->Form->control('enable',[
                    'options'=>[
                        0=>'غیرفعال / آرشیو',
                        1 =>'فعال'],
                    'label'=>'نمایش',
                    'class'=>'form-control']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('password',[
                    'type'=>'text',
                    'label'=>'رمز عبور نمایش',
                    'class'=>'form-control ltr']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('chtype',[
                    'type'=>'select',
                    'empty'=>'- نمایش به همه -',
                    'options'=> $predata->gettype('chtype'),
                    'label'=>'نمایش به',
                    'class'=>'form-control']);?>
            </div>

        </div>
    </div>
        
</div>     
    <?= $this->Form->submit(__('ذخیره'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
<br><br><br>


<?php $this->start('modal');?>
    <?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>