<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'تنظیمات ');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create(null, ['class'=>'p-0', 'url'=>['action'=>'SaveSetting']]);?>
<section id="vertical-tabs">
    <div class="row match-height">
        <div class="col-lg-12">
                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <?= __d('Admin', 'تنظیمات عمومی');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <?= __d('Admin', 'پنل مدیریت');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#security" role="tab" aria-controls="security" aria-selected="false">
                                <?= __d('Admin', 'امنیت');?></a>
                            </li>
                        </ul>

                        
                        <div class="tab-content">
                            <div class="tab-pane active col-12 col-md-6" id="home" role="tabpanel">
                                <?= $this->Func->create_form(Admin\View\Helper\ModuleHelper::options_public(), $result);?>
                            </div>
                            <div class="tab-pane" id="security" role="tabpanel">

                                <div class="row m-0">
                                    <div class="col-sm-4">
                                        <?= $this->Form->control('security_scp_view', [
                                            'label'=>__d('Admin', 'فعال سازی') .' CSP','class'=>'form-control',
                                            'type'=>'select',
                                            'options'=>[
                                                0=> __d('Admin', 'غیرفعال'),
                                                1=>__d('Admin', 'فعال')
                                            ],
                                            'default'=>isset($result['security_scp_view'])?$result['security_scp_view']:'']);?>
                                        <div class="alert alert-secondary">
                                            <?=__d('Admin', 'فعال سازی')?> Content-Security-Policy</div>
                                    </div>
                                </div>
                                

                            </div>

                            <div class="tab-pane" id="profile" role="tabpanel">

                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <?= $this->Form->control('admin_calender', [
                                            'label'=>__d('Admin', 'نوع تقویم'),
                                            'class'=>'form-control',
                                            'type'=>'select',
                                            'style'=>'max-width:200px;',
                                            'options'=>[
                                                0 =>__d('Admin', 'تقویم شمسی'),
                                                1 =>__d('Admin', 'تقویم میلادی')
                                            ],
                                            'default'=>isset($result['admin_calender'])?$result['admin_calender']:'']);?>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $this->Form->control('admin_hdr_showsitetitle', [
                                                    'label'=>__d('Admin', 'عنوان کلید هدر'),
                                                    'class'=>'form-control',
                                                    'default'=>isset($result['admin_hdr_showsitetitle'])?$result['admin_hdr_showsitetitle']:'']);?>
                                                    <div class="alert alert-secondary small">
                                                        - <?=__d('Admin', 'در صورتی که خالی باشد، "نمایش سایت" نشان داده خواهد شد')?>
                                                        <br>
                                                        - <?=__d('Admin', 'در صورتی که خط تیره - قرار بگیرد، کلا نمایش داده نخواهد شد')?>
                                                    </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $this->Form->control('admin_hdr_showsitelink', [
                                                    'label'=>__d('Admin', 'آدرس لینک کلید هدر'),
                                                    'class'=>'form-control',
                                                    'placeholder'=>'http://',
                                                    'dir'=>'ltr',
                                                    'default'=>isset($result['admin_hdr_showsitelink'])?$result['admin_hdr_showsitelink']:'']);?>
                                                    <div class="alert alert-secondary small">
                                                        - <?=__d('Admin', 'در صورتی که آدرس لینک خالی باشد، لینک سایت قرار داده خواهد شد')?>
                                                    </div>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $this->Form->control('admin_hdr_showsitetitle2', [
                                                    'label'=>__d('Admin', 'عنوان کلید هدر'). " 2",
                                                    'class'=>'form-control',
                                                    'default'=>isset($result['admin_hdr_showsitetitle2'])?$result['admin_hdr_showsitetitle2']:'']);?>
                                                    <div class="alert alert-secondary small">
                                                        <?=__d('Admin', 'در صورتی که خالی باشد، نمایش داده نمی شود')?>
                                                    </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $this->Form->control('admin_hdr_showsitelink2', [
                                                    'label'=>__d('Admin', 'آدرس لینک کلید هدر') ." 2",
                                                    'class'=>'form-control',
                                                    'placeholder'=>'http://',
                                                    'dir'=>'ltr',
                                                    'default'=>isset($result['admin_hdr_showsitelink2'])?$result['admin_hdr_showsitelink2']:'']);?>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <?= $this->Form->control('admin_extrastyle', [
                                            'label'=>__d('Admin', 'استایل اضافه مدیریت'),
                                            'class'=>'form-control',
                                            'type'=>'textarea',
                                            'dir'=>'ltr',
                                            'style'=>'min-height:250px;font-size: 12px;line-height: 20px;font-family: tahoma;',
                                            'default'=>isset($result['admin_extrastyle'])?$result['admin_extrastyle']:'']);?>
                                    </li>
                                    <li class="list-group-item"></li>
                                </ul>

                                
                                
                                
                            </div>
                        </div>
                        
                    </div>
        </div>
    </div>
</section>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'mt-3 btn btn-success']);?>
<?= $this->Form->end();?>
<!-- Vertical Tabs end -->

        <!--
            <?php  $this->Form->create(null, ['class'=>'p-0', 'url'=>['action'=>'SaveSetting2']]);?>
            <?php $this->Form->control('reza', [
                'label'=>__d('Admin', 'آدرس لینک کلید هدر'),
                'class'=>'form-control',
                'placeholder'=>'http://',
                'dir'=>'ltr',
                'default'=>isset($result2['reza'])?$result2['reza']:'']);?>
            <?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'mt-3 btn btn-success']);?>
            <?php $this->Form->end();?>
        -->
<?php $this->start('modal');?>
    <?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>