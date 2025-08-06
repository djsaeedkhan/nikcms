<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت سامانه <?=__d('Template', 'همیاری')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if($this->Func->is_serial($result['plugin_challenge'])):
    $hsite = unserialize($result['plugin_challenge']);
    $this->request = $this->request->withData('plugin_challenge',$hsite);
endif;?>

<div class="card"><div class="card-body">
    <div class="nav-tabs-boxed">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#shop" role="tab" aria-controls="shop" aria-selected="true">عمومی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">ایمیل</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false">پیامک</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#export" role="tab" aria-controls="export" aria-selected="false">خروجی</a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- -------------------------------------------------->
            <div class="tab-pane col-sm-8 active" id="shop" role="shop"><br>

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_challenge.phone',[
                            'label'=>'شماره موبایل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'09',
                            'class'=> 'form-control' ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_challenge.email',[
                            'label'=>'آدرس ایمیل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'....[@]....[.]com',
                            'class'=> 'form-control' ]);?>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="export" role="export"><br>
                <?= $this->Form->control('plugin_challenge.factor_title1',[
                    'label'=>'پرینت  -  عنوان اول',
                    'type'=>'text',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_challenge.factor_title2',[
                    'label'=>'پرینت  -  عنوان دوم',
                    'class'=> 'form-control' ]);?><br>
                    
                <?= $this->Form->control('plugin_challenge.factor_tapimg',[
                    'label'=>'تصویر مهر و امضا',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_challenge.factor_logo',[
                    'label'=>'تصویر لوگو',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>
            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="email" role="email"><br>
                <?php $this->Form->control('plugin_challenge.customer_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مشتری پس از ثبت ',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>

                <?php $this->Form->control('plugin_challenge.admin_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مدیریت پس از ثبت ',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="sms" role="sms"><br>
                <!-- <div class="alert alert-secondary">
                    %family% نام و نام خانوادگی<br>
                    %username% نام کاربری<br>
                </div> -->
                <div class="alert alert-warning">
                    در صورتی که متن پیامک خالی باشد، این بخش فعال نخواهد بود (کار نخواهد کرد)
                </div>
                
                <div class="row">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_challenge.sms_new_challenge',[
                            'label'=>'پیامک ثبت '.__d('Template', 'همیاری').' جدید ',
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_challenge.sms_edit_challenge',[
                            'label'=>'پیامک ویرایش '.__d('Template', 'همیاری').' قبلی ',
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------->

            <!-- -------------------------------------------------->
        </div>
    </div>

</div></div>
<?php 
echo $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>