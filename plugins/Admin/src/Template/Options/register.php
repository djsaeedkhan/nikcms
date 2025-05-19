<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Admin', 'تنظیمات ورود')?>
                     / 
                    <?= __d('Admin', 'ثبت نام')?>
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
            <div class="card1">
                <div class="card-body1">
                    <div class="nav-vertical">
                        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab" aria-controls="home" aria-selected="true">
                                <?= __d('Admin', 'ورود کاربران');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#profile-1" role="tab" aria-controls="profile" aria-selected="false">
                                <?= __d('Admin', 'ثبت نام کاربران');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#remember-1" role="tab" aria-controls="remember" aria-selected="false">
                                <?= __d('Admin', 'یادآوری پسورد');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#logout-1" role="tab" aria-controls="logout" aria-selected="false">
                                <?= __d('Admin', 'خروج از سایت');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#home2-2" role="tab" aria-controls="home2" aria-selected="true">
                                <?= __d('Admin', 'تنظیمات کلی');?></a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active col-7" id="home-1" role="tabpanel">
                                <?php
                                    echo $this->Form->control('complete_profile', [
                                        'type' => 'checkbox',
                                        'label'=>__d('Admin', 'تکمیل پروفایل'),
                                        'default'=>isset($result['complete_profile'])?$result['complete_profile']:''
                                    ]).
                                    '<small>'.__d('Admin', 'در صورتی که مشخصات کاربر ناقص باشد، به صفحه پروفایل هدایت شده تا نسبت به تکمیل اقدام نماید'). '</small>'.'<br><br>';

                                    echo $this->Form->control('login_status', [
                                        'type'=>'select',
                                        'label'=>__d('Admin', 'وضعیت ورود کاربران'),
                                        'class'=>'form-control mb-2',
                                        'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                        'options'=>[
                                            1 =>__d('Admin', 'فعال') .' - ' .__d('Admin', 'امکان ورود'), 
                                            0 =>__d('Admin', 'غیرفعال') . ' - ' .__d('Admin', 'عدم امکان ورود')
                                        ],
                                        'default'=>isset($result['login_status'])?$result['login_status']:'']);

                                    echo $this->Form->control('login_alert', [
                                        'type'=>'textarea',
                                        'label'=>__d('Admin', 'پیغام عدم امکان ورود'),
                                        'class'=>'form-control mb-2',
                                        'default'=>isset($result['login_alert'])?$result['login_alert']:'']);

                                    echo $this->Form->control('login_footertext', [
                                        'type'=>'textarea',
                                        'label'=>__d('Admin', 'متن پایین صفحه'),
                                        'class'=>'form-control mb-2',
                                        'default'=>isset($result['login_footertext'])?$result['login_footertext']:'']);

                                    echo $this->Form->control('login_linkurl', [
                                        'type'=>'text',
                                        'label'=>__d('Admin', 'لینک اختصاصی ورود کاربران'),
                                        'class'=>'form-control ltr',
                                        'dir'=>'ltr',
                                        'default'=>isset($result['login_linkurl'])?$result['login_linkurl']:'']);

                                        echo '<div class="mb-3"><small>'.
                                            __d('Admin', 'صفحه لاگین: در صورتی که خالی باشد، لینک پیش فرض سامانه قرار داده می شود') .
                                            '.</small></div>';

                                    echo $this->Form->control('login_redirecturl', [
                                        'type'=>'text',
                                        'label'=>__d('Admin', 'آدرس پس از لاگین'),
                                        'class'=>'form-control ltr',
                                        'dir'=>'ltr',
                                        'default'=>isset($result['login_redirecturl'])?$result['login_redirecturl']:'']);

                                        echo '<div class="mb-3"><small>'.
                                            __d('Admin', 'صفحه لاگین: پس از ورود به چه آدرسی هدایت شود').
                                            '</small></div>';

                                    /* echo $this->Form->control('admin_canview', [
                                        'type'=>'select',
                                        'options'=>[],
                                        'label'=>' دسترسی به مدیریت','class'=>'form-control dir',
                                        'default'=>isset($result['admin_canview'])?$result['admin_canview']:'']);
                                        echo '<div class="mb-3"><small>آیا کاربران عضو بتوانند بخش مدیریت را مشاهده کنند </small></div>'; */

                                    echo $this->Form->control('login_backimg', [
                                        'type'=>'text',
                                        'label'=>__d('Admin', 'آدرس تصویر لاگین'),
                                        'class'=>'form-control mb-2 ltr',
                                        'placeholder' =>'http://',
                                        'default'=>isset($result['login_backimg'])?$result['login_backimg']:'']);

                                    echo $this->Form->control('login_style', [
                                        'type'=>'textarea',
                                        'label'=>__d('Admin', 'استایل اختصاصی لاگین'). ' (CSS)',
                                        'class'=>'form-control mb-2 ltr',
                                        'default'=>isset($result['login_style'])?$result['login_style']:'']);

                                    echo $this->Form->control('login_key', [
                                        'type'=>'text',
                                        'label'=>__d('Admin', 'کلید ورود'),
                                        'class'=>'form-control mb-2 ltr',
                                        'default'=>isset($result['login_key'])?$result['login_key']:'']);
                                    ?>
                                    <div class="alert alert-info">
                                        <?= __d('Admin', 'با این تنظیم در صورتی که وضعیت ورود: غیرفعال باشد میتوانید  وارد سایت شوید')?>.
                                    
                                        <?= $this->Html->link('['.__d('Admin', 'لینک ورود به سایت') .']',[
                                            'plugin'=>false,
                                            'controller'=>'Users',
                                            'action'=>'login','?'=>['key'=>(isset($result['login_key']) or $result['login_key']!='')?$result['login_key']:'not set']],
                                            ['target'=>'_blank']);?>
                                    </div>

                                    <?php
                                    echo $this->Func->create_form([
                                        'login_expired_check' => [
                                            'name'=>'login_expired_check',
                                            'type'=>'select',
                                            'options'=>$this->Func->Predata('yesno'),
                                            'title' => __d('Admin', 'بررسی تاریخ انقضای کاربر هنگام ورود')
                                        ]],
                                        $result );
                                    echo $this->Func->create_form([
                                        'login_expired_alarm' => [
                                            'name'=>'login_expired_alarm',
                                            'type'=>'text',
                                            'title' => __d('Admin', 'متن خطای نمایشی به کاربر')
                                        ]],
                                        $result );
                                    ?>
                            </div>
                            <!-- ----------------------------------------------------->
                            <div class="tab-pane col-7" id="logout-1" role="tabpanel">
                                <?= $this->Form->control('logout_url', [
                                    'label'=>__d('Admin', 'آدرس پس از خروج از سایت'),
                                    'class'=>'form-control mb-2',
                                    'dir'=>'ltr',
                                    'placeholder'=>'https://',
                                    'default'=>isset($result['logout_url'])?$result['logout_url']:'']);?>

                                <?= $this->Form->control('logout_alert', [
                                    'label'=>__d('Admin', 'پیام پس از خروج از سایت'),
                                    'class'=>'form-control mb-2',
                                    'type'=>'textarea',
                                    'default'=>isset($result['logout_alert'])?$result['logout_alert']:'']);?>

                            </div>
                            <!-- ----------------------------------------------------->
                            <div class="tab-pane col-7" id="profile-1" role="tabpanel">
                                <?= $this->Func->create_form(\Admin\View\Helper\ModuleHelper::options_register(),$result )?>
                            </div>
                            <!-- ----------------------------------------------------->
                            <div class="tab-pane col-7" id="home2-2" role="tabpanel">
                                
                                <div class="row alert alert-info">
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('template_viewin', [
                                            'type'=>'select',
                                            'label'=>__d('Admin', 'نمایش در قالب سایت'),
                                            'class'=>'form-control mb-2',
                                            'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                            'options' => $this->Func->Predata('yesno'),
                                            'default'=>isset($result['template_viewin'])?$result['template_viewin']:'']);?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('template_layout', [
                                            'type'=>'select',
                                            'label'=>__d('Admin', 'نمایش در قالب سایت'),
                                            'class'=>'form-control mb-2',
                                            'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                            'options' => $this->Func->Predata('yesno'),
                                            'default'=>isset($result['template_layout'])?$result['template_layout']:'']);?>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('template_logint', [
                                            'type'=>'select',
                                            'label'=>'استفاده از "ورود" اختصاصی قالب',
                                            'class'=>'form-control mb-2',
                                            'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                            'options' => $this->Func->Predata('yesno'),
                                            'default'=>isset($result['template_logint'])?$result['template_logint']:'']);?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $this->Form->control('template_regt', [
                                            'type'=>'select',
                                            'label'=>__d('Admin', 'استفاده از "ثبت نام" اختصاصی قالب'),
                                            'class'=>'form-control mb-2',
                                            'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                            'options' => $this->Func->Predata('yesno'),
                                            'default'=>isset($result['template_regt'])?$result['template_regt']:'']);?>
                                    </div>
                                </div>
                                    
                                <?= $this->Form->control('template_style', [
                                    'type'=>'textarea',
                                    'label'=>__d('Admin', 'استایل نمایش در قالب سایت'),
                                    'class'=>'form-control',
                                    'dir'=>'ltr',
                                    'default'=>isset($result['template_style'])?$result['template_style']:'']);?>
                                    <small class="mb-2">
                                        <?= __d('Admin', 'بدون نیاز به')?> &lt;style&gt;&lt;/style&gt;
                                    </small><br><br>

                                <?= $this->Form->control('template_script', [
                                    'type'=>'textarea',
                                    'label'=>__d('Admin', 'اسکریپت نمایش در قالب سایت'),
                                    'class'=>'form-control',
                                    'dir'=>'ltr',
                                    'default'=>isset($result['template_script'])?$result['template_script']:'']);?>

                                    <small class="mb-2">
                                        <?= __d('Admin', 'بدون نیاز به')?> &lt;script&gt;&lt;/script&gt;
                                    </small><br><br>
                            </div>
                            <!-- ----------------------------------------------------->
                            <div class="tab-pane col-7" id="remember-1" role="tabpanel">
                                <?php
                                echo $this->Form->control('remember_status', [
                                    'type'=>'select',
                                    'label'=>__d('Admin', 'وضعیت یادآوری پسورد'),
                                    'class'=>'form-control mb-2',
                                    'empty'=>'-- '.__d('Admin', 'انتخاب کنید').' --',
                                    'options'=>[
                                        1 =>__d('Admin', 'فعال'), 
                                        0 =>__d('Admin', 'غیرفعال')
                                    ],
                                    'default'=>isset($result['remember_status'])?$result['remember_status']:'']);

                                echo $this->Form->control('remember_alert', [
                                    'type'=>'textarea',
                                    'label'=>__d('Admin', 'پیغام بالای صفحه'),
                                    'class'=>'form-control mb-2',
                                    'default'=>isset($result['remember_alert'])?$result['remember_alert']:'']);

                                echo $this->Form->control('remember_backimg', [
                                    'type'=>'text',
                                    'label'=>__d('Admin', 'آدرس تصویر'),
                                    'class'=>'form-control mb-2 ltr',
                                    'placeholder' =>'http://',
                                    'default'=>isset($result['remember_backimg'])?$result['remember_backimg']:'']);

                                echo $this->Form->control('remember_style', [
                                    'type'=>'textarea',
                                    'label'=>__d('Admin', 'استایل اختصاصی').'  (CSS)',
                                    'class'=>'form-control mb-2 ltr',
                                    'default'=>isset($result['remember_style'])?$result['remember_style']:'']);
                                    
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->Form->button(__d('Admin', 'ثبت اطلاعات'),['class'=>'btn btn-success']);?>
<?= $this->Form->end() ?>
