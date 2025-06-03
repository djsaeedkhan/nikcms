<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    <?= __d('Ticketing', 'تنظیمات افزونه تیکت')?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <div class="btn-group pull-right" style="margin-right:5px;" role="group">
                        <button class="btn btn-success dropdown-toggle " style="padding: 6px !important;" id="btnGroupVerticalDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather='chevron-down'></i> دسترسی</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2" >
                            <?= $this->Html->link(__d('Ticketing', 'لیست وضعیت تیکت'),
                                ['controller' => 'Ticketstatuses', 'action' => 'index'],
                                ['class'=>'dropdown-item']) ?>

                            <?= $this->Html->link(__d('Ticketing', 'لیست اولویت تیکت'), 
                                ['controller' => 'Ticketpriorities', 'action' => 'index'],
                                ['class'=>'dropdown-item']) ?>

                            <?= $this->Html->link(__d('Ticketing', 'لیست دسته بندی تیکت'), 
                                ['controller' => 'Ticketcategories', 'action' => 'index'],
                                ['class'=>'dropdown-item']) ?>

                            <!-- <?= $this->Html->link(__d('Ticketing', 'List Ticketaudits'), 
                                ['controller' => 'Ticketaudits', 'action' => 'index'],
                                ['class'=>'dropdown-item']) ?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['plugin_ticket']);
    $this->request = $this->request->withData('plugin_ticket',$hsite);
endif;?>

<div class="card"><div class="card-body">
    <div class="nav-tabs-boxed">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#shop" role="tab" aria-controls="shop" aria-selected="true"><?= __d('Ticketing', 'عمومی')?></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="true"> مالی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false"> پیامک</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#factor" role="tab" aria-controls="factor" aria-selected="false"> فاکتور</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#terminal" role="tab" aria-controls="terminal" aria-selected="false"> درگاه بانکی</a>
            </li> -->
        </ul>
        <div class="tab-content">
            <!-- -------------------------------------------------->
            <div class="tab-pane col-sm-8 active" id="shop" role="shop"><br>
                <!-- <h4 class="card-title fw-b"></h4> -->
                
                <?= $this->Form->control('plugin_ticket.client_webview', [
                    'label'=>__d('Ticketing', 'نمایش تیکت در قالب سایت'),
                    'type'=>'select',
                    'options'=>$this->Func->predata('yesno'),
                    'empty'=>'--',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_ticket.client_reply_order', [
                    'label'=>__d('Ticketing', 'ترتیب نمایش پاسخ ها در پنل کاربر'),
                    'type'=>'select',
                    'options'=>[
                        'ASC'=>__d('Ticketing', 'صعودی'),
                        'DESC'=>__d('Ticketing', 'نزولی')
                    ],
                    'empty'=>'--',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_ticket.allow_uploadfile', [
                    'label'=>__d('Ticketing', 'امکان آپلود فایل در تیکت'),
                    'type'=>'select',
                    'options'=>$this->Func->predata('yesno'),
                    'empty'=>'--',
                    'class'=> 'form-control' ]);?><br>

                <!-- <div class="row">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_ticket.store_province', [
                            'label'=> __d('Ticketing', 'استان'),
                            'type'=>'select',
                            'empty'=>'-- '.__d('Ticketing', 'انتخاب کنید') .' --',
                            'options'=> $this->Func->province_list(),
                            'class'=> 'form-control' ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control(
                            'plugin_ticket.store_city', [
                                'label'=>__d('Ticketing', 'شهر'),
                                'class'=> 'form-control' ]);?><br>
                    </div>
                </div> -->

                <!-- <?= $this->Form->control(
                    'plugin_ticket.store_address', [
                    'label'=>__d('Ticketing', 'آدرس کامل'),
                    'type'=>'textarea',
                    'class'=> 'form-control' ]); ?><br>
                
                <?= $this->Form->control('plugin_ticket.store_zipcode',[
                    'label'=>'کدپستی',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><br><hr>
                
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_ticket.sh_meli',[
                            'label'=>'شناسه ملی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_ticket.sh_sabt',[
                            'label'=>'شماره ثبت',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_ticket.sh_eghtesadi',[
                            'label'=>'شماره اقتصادی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                </div><hr><br> -->


                <!-- <div class="row mb-2">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_ticket.phone',[
                            'label'=>'شماره موبایل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'09',
                            'class'=> 'form-control' ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_ticket.email',[
                            'label'=>'آدرس ایمیل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'....[@]....[.]com',
                            'class'=> 'form-control' ]);?>
                    </div>
                    
                </div><hr> -->
            </div>
            <!-- -------------------------------------------------->
           
            <div class="tab-pane col-6" id="price" role="price"><br>
                <!-- <h4 class="card-title fw-b">پیکربندی واحد پولی</h4> -->
                <?php
                $currency = [];
                unset($currency['EUR'],$currency['IQD'],$currency['RUB'],$currency['USD']);
                echo $this->Form->control('plugin_ticket.currency',[
                    'label'=>'انتخاب واحد پولی',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> $currency,
                    'class'=> 'form-control' ]);?>

                <?php $this->Form->control('plugin_ticket.text_price_zero',[
                    'label'=>'متن مبلغ هنگام صفر بودن مبلغ محصول',
                    'class'=> 'form-control' ]);?>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_product" role="_product"><br>
                <?php $this->Form->control('plugin_ticket.cart_redirect_after_add',[
                    'label'=>' انتقال به برگه سبد خرید بعد از «افزودن به سبد»',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><hr>

                <?php $this->Form->control('plugin_ticket.text_addtocart',[
                    'label'=>'متن پیش فرض "افزودن به سبد خرید"',
                    'class'=> 'form-control' ]);?><br>

                <?php $this->Form->control('plugin_ticket.link_addtocart',[
                    'label'=>'لینک پیش فرض "افزودن به سبد خرید"',
                    'placeholder'=>'http://',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?php $this->Form->control('plugin_ticket.product_default_image',[
                    'label'=>'تصویر پیش فرض محصولات',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?php $this->Form->control('plugin_ticket.product_image_count',[
                    'label'=>'تعداد باکس تصاویر محصول',
                    'type'=>'number',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><hr>

                <?php $this->Form->control('plugin_ticket.default_sort',[
                    'label'=>'سورت پیش فرض محصولات',
                    'type'=>'select','empty'=>' -- انتخاب کنید -- ','dir'=>'ltr',
                    'options'=>[
                        'view.desc'=>'پربازدیدترین (view.desc)',
                        'stock.desc'=>'محصولات موجود (stock.desc)',
                        'order.desc'=>'پرفروش‌ترین‌ (order.desc)',
                        'popularity.desc'=>'محبوب‌ترین (popularity.desc)',
                        'new.desc'=>'جدیدترین (new.desc)',
                        'price.asc'=>'ارزان‌ترین (price.asc)',
                        'price.desc'=>'گران‌ترین (price.desc)',
                    ],
                    'class'=> 'form-control' ]);?><hr>
            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="_factor" role="_factor"><br>
                <?php $this->Form->control('plugin_ticket.factor_title1',[
                    'label'=>'پرینت فاکتور -  عنوان اول',
                    'type'=>'text',
                    'class'=> 'form-control' ]);?><br>

                <?php $this->Form->control('plugin_ticket.factor_title2',[
                    'label'=>'پرینت فاکتور -  عنوان دوم',
                    'class'=> 'form-control' ]);?><br>
                    
                <?php $this->Form->control('plugin_ticket.factor_tapimg',[
                    'label'=>'تصویر مهر و امضا',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>

                <?php $this->Form->control('plugin_ticket.factor_logo',[
                    'label'=>'تصویر لوگو',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>
                    
                <br><br>

            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_order" role="_order"><br>
                <?php $this->Form->control('plugin_ticket.order_savestatus',[
                    'label'=>'وضعیت ثبت سفارشات',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> [],
                    'class'=> 'form-control' ]);?><br><br>

                <?php $this->Form->control('plugin_ticket.enable_guest_checkout',[
                    'label'=>' اجازه ثبت سفارش به مشتری‌ها دهید بدون نیاز به حساب کاربری',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>

                <?php $this->Form->control('plugin_ticket.enable_checkout_login_reminder',[
                    'label'=>'به مشتری اجازه دهید در جریان پرداخت به حساب کاربری خود وارد شود',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_email" role="_email"><br>
                <?php $this->Form->control('plugin_ticket.customer_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مشتری پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>

                <?php $this->Form->control('plugin_ticket.admin_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مدیریت پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="sms" role="sms"><br>
                <div class="alert alert-secondary">
                    %family% <?= __d('Ticketing', 'نام و نام خانوادگی')?> <br>
                    %username% <?= __d('Ticketing', 'نام کاربری')?> <br>
                    %course_title% <?= __d('Ticketing', 'نام دوره')?> <br>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_ticket.smstext_10dayexpire',[
                            'label'=>'متن پیامک 10 روز مانده تا منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_ticket.smstext_expired',[
                            'label'=>'متن پیامک منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                </div>
                <!-- <hr style="border-color: #7569f1;"> -->

                <div class="row">
                    <?php /* foreach( LmsHelper::Predata('order_status') as $k=>$v):?>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_ticket.sms_'.$k,[
                            'label'=>$v,
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <?php endforeach */?>
                    
                </div>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="terminal" role="terminal"><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        /* $this->Form->setTemplates([
                            'nestingLabel' => '{{hidden}}{{input}}<label {{attrs}} class="pr-1 pl-1">{{text}}</label>',
                            'formGroup' => '{{input}}{{label}}',
                        ]); */
                        
                        echo 'انتخاب درگاه بانکی'.
                        $this->Form->select('plugin_ticket.terminal_list', 
                            [], [
                            //'multiple' => 'checkbox',
                            'class'=>'form-control',
                            'label'=>'انتخاب درگاه بانکی',
                        ]);?><br>

                        <?php /*  $this->Form->control('plugin_ticket.terminal_data1',[
                            'label'=>'کد  درگاه یک',
                            'dir'=>'ltr',
                            'style'=>'font-family: initial;',
                            'class'=> 'form-control' ]); */?><br>

                        <?= $this->Form->control('plugin_ticket.merchant_id',[
                            'type'=>'text',
                            'label'=>'Merchant ID',
                            'dir'=>'ltr',
                            'style'=>'font-family: tahoma;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_ticket.terminal_key',[
                            'type'=>'text',
                            'label'=>'Terminal Key',
                            'dir'=>'ltr',
                            'style'=>'font-family: tahoma;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_ticket.terminal_id',[
                            'type'=>'text',
                            'label'=>'Terminal Id',
                            'dir'=>'ltr',
                            'style'=>'font-family: tahoma;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            <h4>فیلدهای مورد نیاز درگاه بانکی</h4><br>
                            زرین پال:Merchant ID
                            <br><br>
                            ملی: Merchant ID, Terminal Key, Terminal Id
                            
                        </div>
                    
                    </div>
                
                </div>

            </div>
            <!-- -------------------------------------------------->
            <br>
        </div>
    </div>

</div></div>
<?php 
echo $this->Form->submit(
    __d('Ticketing', 'ذخیره اطلاعات'),
    ['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>
