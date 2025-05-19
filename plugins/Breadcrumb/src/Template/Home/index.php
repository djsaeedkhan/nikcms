<?php
use \Admin\View\Helper\ModuleHelper;

echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['brcrumb_plugin']);
    $this->request->withData('brcrumb_plugin',$hsite);
    @$this->request->data['brcrumb_plugin'] = $hsite;
endif;?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Breadcrumb', 'مدیریت افزونه مکان نما');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
            aria-selected="true"><?= __d('Breadcrumb', 'لیست عنوان ها')?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#exclude" role="tab" aria-controls="exclude" 
            aria-selected="true"><?= __d('Breadcrumb', 'مستثنی کردن')?></a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active show" id="home" role="tabpanel">
        <div class="alert alert-dark">
            <?= __d('Breadcrumb', 'در صورتی که عنوانی خالی باشد، مقدار پیش فرش نمایش داده می شود')?>
        </div>
        <div class="card"><div class="card-body col-sm-6">
            <?php
            $arr = [
                'title_home'=>__d('Breadcrumb', 'عنوان صفحه نخست'),
                'title_single'=>__d('Breadcrumb', 'عنوان ادامه مطلب'),
                'title_search'=>__d('Breadcrumb', 'عنوان جستجو'),
                'title_tag'=>__d('Breadcrumb', 'عنوان برچسب'),
                'title_category'=>__d('Breadcrumb', 'عنوان دسته بندی'),
            ];
            foreach($arr as $a=>$t)
                echo $this->Form->control('brcrumb_plugin.'.$a , [
                    'label'=> $t, 'class'=> 'form-control mb-1',
                ]);?>
        </div></div>
    </div>

    <div class="tab-pane" id="exclude" role="tabpanel">
        <div class="alert alert-dark">
            <?= __d('Breadcrumb', 'پست تایپ هایی که نمیخواهید در آن مکان نما نمایش داده شوند را مشخص کنید')?>
        </div>
        <div class="card"><div class="card-body col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <?=$this->Form->control('brcrumb_plugin.exclude_index', [
                        'type' => 'select',
                        'label'=>'<b>'.__d('Breadcrumb', 'تنظیمات صفحه ایندکس') .'</b><br>',
                        'style' =>'margin-left: 10px !important;',
                        'multiple'=>'checkbox',
                        'escape'=>false,
                        'options' => $this->Func->posttype_list(),
                        'default'=>isset($result['exclude_index'])?unserialize($result['exclude_index']):'',  ]);?>

                </div>
                <div class="col-sm-6">
                    <?=$this->Form->control('brcrumb_plugin.exclude_single', [
                        'type' => 'select',
                        'label'=>'<b>'.__d('Breadcrumb', 'تنظیمات صفحه ادامه مطلب') .'</b>',
                        'style' =>'margin-left: 10px !important;',
                        'multiple'=>'checkbox',
                        'escape'=>false,
                        'options' => $this->Func->posttype_list(),
                        'default'=>isset($result['exclude_single'])?unserialize($result['exclude_single']):'',
                        ]);
                    ?>
                </div>
            </div>
        </div></div>
    </div>
</div>
<?= $this->Form->submit(__d('Breadcrumb', 'ثبت اطلاعات'),['class'=>'btn btn-success col-xs-3 mt-1'])?><br><br>
<?= $this->Form->end()?>