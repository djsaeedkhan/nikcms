<?php
echo $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['coming_plugin']);
    $this->request = $this->request->withData('coming_plugin.setting',$hsite['setting']);
endif;
?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('افزونه به زودی');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-controls="home" 
                aria-selected="true">تنظیمات اصلی</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" 
                aria-selected="false">متن نمایشی</a>
        </li>
        
    </ul>
    <div class="card"><div class="card-body">
    <div class="tab-content">
        <?= '<div class="alert alert-secondary">حالت تعمیر '.
                (($this->Query->info('maintenance_mode'))?
                '<span class="badge badge-success">فعال</span>':
                '<span class="badge badge-danger">غیرفعال</span>').
                ' است</div>';?>

        <div class="tab-pane active show col-sm-6" id="home" role="tabpanel">
            
            <?php
            echo $this->Form->control('coming_plugin.setting.member_mode', [
                'type'=> 'select',
                'options' =>[0 => 'غیرفعال ', 1 => 'فعال'],
                'label'=> 'نمایش سایت در صورت ورود کاربر',
                'class'=> 'form-control',
            ]);
            echo '<small class="text-secondary mb-2">در صورت ورود (Login)، سایت به کاربر نمایش داده خواهد شد </small><br><br>';

            echo $this->Form->control('coming_plugin.setting.login_mode', [
                'type'=> 'select',
                'options' =>[0 => 'غیرفعال ', 1 => 'فعال'],
                'label'=> 'هدایت به صفحه ورود کاربران',
                'class'=> 'form-control',
            ]);
            echo '<small class="text-secondary mb-2">به جای نمایش متن، به صفحه ورود کاربران سایت هدایت خواهد شد</small><br><br>';
            ?>
            
        </div>
        <div class="tab-pane col-sm-12" id="profile" role="tabpanel">
            <?php 
            echo $this->Form->control('coming_plugin.setting.display_text', [
                'type'=> 'textarea',
                'style' =>'height:400px;',
                'label'=> 'متن نمایشی در حالت فعال بودن وضعیت " تعمیر "',
                'class'=> 'form-control ltr',
            ]);?>
        </div>
        </div></div>
    </div>
</div>

<?= $this->Form->button('بروز رسانی',['class'=>'btn btn-sm btn-success col-xs-3'])?>
<?= $this->Form->end()?>

<?php $this->start('modal');?>
<?= $this->cell('Admin.Favorite::upload',[]);?>
<?php $this->end(); ?>