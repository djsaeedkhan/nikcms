<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="nav-tabs-boxed">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true">
            <?= __d('Admin', 'ورود کاربران');?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">
            <?= __d('Admin', 'ثبت نام کاربران');?></a>
        </li>
        
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="home-1" role="tabpanel">
            <?php
                echo $this->Form->create(null, ['class'=>'col-sm-7', 'url'=>['action'=>'SaveSetting']]);
                echo $this->Form->control('login_status', [
                    'type'=>'select','label'=>'وضعیت ورود کاربران','class'=>'form-control mb-3','empty'=>'-- انتخاب کنید --',
                    'options'=>[1 =>'فعال - امکان ورود', 0 =>'غیرفعال - عدم امکان ورود'],
                    'default'=>isset($result['login_status'])?$result['login_status']:'']);

                echo $this->Form->control('login_alert', [
                    'type'=>'textarea','label'=>'پیغام عدم امکان ورود','class'=>'form-control mb-3',
                    'default'=>isset($result['login_alert'])?$result['login_alert']:'']);

                echo $this->Form->control('login_linkurl', [
                    'type'=>'text','label'=>'لینک اختصاصی ورود کاربران','class'=>'form-control dir',
                    'default'=>isset($result['login_linkurl'])?$result['login_linkurl']:'']);
                    echo '<div class="mb-3"><small>در صورتی که خالی باشد، لینک پیش فرض سامانه قرار داده می شود.</small></div>';

                echo $this->Form->control('login_backimg', [
                    'type'=>'text','label'=>'آدرس تصویر لاگین','class'=>'form-control mb-3 ltr',
                    'placeholder' =>'http://',
                    'default'=>isset($result['login_backimg'])?$result['login_backimg']:'']);

                echo $this->Form->control('login_style', [
                    'type'=>'textarea','label'=>'استایل اختصاصی لاگین (CSS)','class'=>'form-control mb-3 ltr',
                    'default'=>isset($result['login_style'])?$result['login_style']:'']);

                echo $this->Form->control('login_key', [
                    'type'=>'text','label'=>'کلید ورود','class'=>'form-control mb-3 ltr',
                    'default'=>isset($result['login_key'])?$result['login_key']:'']);
                ?>
                <div class="alert alert-info">با این تنظیم در صورتی که وضعیت ورود: غیرفعال باشد میتوانید  وارد سایت شوید.
                <?= $this->Html->link('[لینک ورود به سایت]',[
                    'plugin'=>false,
                    'controller'=>'Users',
                    'action'=>'login','?'=>['key'=>(isset($result['login_key']) or $result['login_key']!='')?$result['login_key']:'not set']],
                    ['target'=>'_blank']);?></div>
                <?= $this->Form->button(__d('Admin', 'Submit'),['class'=>'btn btn-success']);?>
                <?= $this->Form->end() ?>
        </div>
        <div class="tab-pane" id="profile-1" role="tabpanel">
            <?php
                echo $this->Form->create(null, ['class'=>'col-sm-7', 'url'=>['action'=>'SaveSetting']]);
                echo $this->Func->create_form(\Admin\View\Helper\ModuleHelper::options_register(),$result );
                echo $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);
                echo $this->Form->end();
                ?>
        </div>
    </div>
</div>