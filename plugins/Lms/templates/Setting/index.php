<?php
use Lms\View\Helper\LmsHelper;
?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت سامانه آموزشی
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"></ol>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(isset($result) and $result != ""):
    $hsite = unserialize($result);
    $this->request = $this->request->withData('plugin_lms',$hsite);
endif;?>

<div class="card"><div class="card-body">
    <div class="nav-tabs-boxed">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#shop" role="tab" aria-controls="shop" aria-selected="true">عمومی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">پیغام ها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="true"> مالی</a>
            </li>
           <!--  <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="true"> پرداخت</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#course" role="tab" aria-controls="course" aria-selected="true">دوره ها</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="false"> محصولات</a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false"> انبار</a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false"> سفارش</a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false"> ایمیل</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false"> پیامک</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#factor" role="tab" aria-controls="factor" aria-selected="false"> فاکتور</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#terminal" role="tab" aria-controls="terminal" aria-selected="false"> درگاه بانکی</a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- -------------------------------------------------->
            <div class="tab-pane col-sm-8" id="dashboard" role="dashboard"><br>
            
                <h4 class="alert alert-secondary">متن نمایشی تمام شدن فرصت شرکت در آزمون</h4>
                <?= $this->Form->control('plugin_lms.exam_limit_try_type',[
                    'label'=>'نوع نمایش',
                    'type'=>'select','options'=>[
                        'success'=>'success',
                        'danger'=>'danger',
                        'info'=>'info',
                        'primary'=>'primary',
                        'secondary'=>'secondary',
                        'warning'=>'warning',
                    ],
                    'class'=> 'form-control' ]);?><br>
                <?= $this->Form->control('plugin_lms.exam_limit_try',[
                    'label'=>'متن نمایشی',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>

                <h4 class="alert alert-secondary">متن بالای لیست دوره ها</h4>
                <?= $this->Form->control('plugin_lms.course_topalert_type',[
                    'label'=>'نوع نمایش',
                    'type'=>'select','options'=>[
                        'success'=>'success',
                        'danger'=>'danger',
                        'info'=>'info',
                        'primary'=>'primary',
                        'secondary'=>'secondary',
                        'warning'=>'warning',
                    ],
                    'class'=> 'form-control' ]);?><br>
                <?= $this->Form->control('plugin_lms.course_topalert',[
                    'label'=>'متن نمایشی',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>

                <hr>
                <h4 class="alert alert-secondary">متن بالای صفحه داشبورد</h4>
                <?= $this->Form->control('plugin_lms.dashboard_topalert_type',[
                    'label'=>'نوع نمایش پیغام داشبورد',
                    'type'=>'select','options'=>[
                        'success'=>'success',
                        'danger'=>'danger',
                        'info'=>'info',
                        'primary'=>'primary',
                        'secondary'=>'secondary',
                        'warning'=>'warning',
                    ],
                    'class'=> 'form-control' ]);?><br>
                <?= $this->Form->control('plugin_lms.dashboard_topalert',[
                    'label'=>'متن نمایشی در داشبورد ورودی کاربر',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>

                <br>
                <hr>
                <h4 class="alert alert-secondary">متن بالای لیست دوره ها سایت
                    <br><small>در حالتی که هنوز جلسه ای انتخاب نشده است</small></h4>
                <?= $this->Form->control('plugin_lms.guest_course_detail_top_alert',[
                    'label'=>'متن نمایشی بالای صفحه لیست دروس دوره ها (سایت اصلی)',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>
                <br>
            </div>
            <div class="tab-pane col-sm-8 active" id="shop" role="shop"><br>
                <!-- <h4 class="card-title fw-b"></h4> -->
                
                <?= $this->Form->control('plugin_lms.client_webview',[
                    'label'=>'نمایش پنل کاربری در قالب سایت',
                    'type'=>'select','options'=>$this->Func->predata('yesno'),
                    'empty'=>'--',
                    'class'=> 'form-control']);?><br>

                <!-- <div class="row">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_lms.store_province',[
                            'label'=>'استان',
                            'type'=>'select',
                            'empty'=>'-- انتخاب کنید --',
                            'options'=> $this->Func->province_list(),
                            'class'=> 'form-control']);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_lms.store_city',[
                            'label'=>'شهر',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                </div> -->

                <!-- <?= $this->Form->control('plugin_lms.store_address',[
                    'label'=>'آدرس کامل',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?><br>
                
                <?= $this->Form->control('plugin_lms.store_zipcode',[
                    'label'=>'کدپستی',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><br><hr>
                
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_lms.sh_meli',[
                            'label'=>'شناسه ملی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_lms.sh_sabt',[
                            'label'=>'شماره ثبت',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_lms.sh_eghtesadi',[
                            'label'=>'شماره اقتصادی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                </div><hr><br> -->


                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_lms.phone',[
                            'label'=>'شماره موبایل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'09',
                            'class'=> 'form-control' ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_lms.email',[
                            'label'=>'آدرس ایمیل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'....[@]....[.]com',
                            'class'=> 'form-control' ]);?>
                    </div>
                    
                </div><hr>
            </div><!-- -------------------------------------------------->
           
            <div class="tab-pane col-6" id="course" role="price"><br>

                <?= $this->Form->control('plugin_lms.course_time_between_two_factors',[
                    'label'=>'فاصله زمانی بین دو فاکتور (عدد روز)',
                    'type'=>'number',
                    'class'=> 'form-control ltr' ]);?>
                <div class="alert alert-secondary">
                    توضیح:<br>
                    <ul>
                        <li>فاصله زمانی بین دو فاکتور ثبت شده - پرداخت شده یا نشده</li>
                        <li>اگر این عدد خالی یا صفر باشد، این شرط اعمال نخواهد شد</li>
                        <li>فقط عدد روز ،مثلا 2 ، وارد شود</li>
                    </ul>
                </div>

                <?= $this->Form->control('plugin_lms.course_time_between_two_factors_alert',[
                    'label'=>'پیغام فاصله زمانی بین دو فاکتور',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>

                <hr>

                <?= $this->Form->control('plugin_lms.course_related_limit',[
                    'label'=>'مدت فاصله بین فعال سازی دوره های مرتبط (عدد روز)',
                    'type'=>'number',
                    'class'=> 'form-control ltr' ]);?>
                <div class="alert alert-secondary">
                    توضیح:<br>
                    <ul>
                        <li>در صورتی که دوره دارای "دوره پیش نیاز" باشد، چه مدت زمان پس از دریافت دوره پیش نیاز، امکان گرفتن دوره اصلی باشد </li>
                        <li>اگر این عدد خالی یا صفر باشد، این شرط اعمال نخواهد شد</li>
                        <li>فقط عدد روز ،مثلا 2 ، وارد شود</li>
                    </ul>
                </div>
                <br>

                <?= $this->Form->control('plugin_lms.course_related_limit_alert',[
                    'label'=>'پیغام اطلاع رسانی مدت فاصله',
                    'class'=> 'form-control','type'=>'textarea' ]);?>

                <hr>
                <?= $this->Form->control('plugin_lms.course_finished_alert',[
                    'label'=>'متن پس از پایان دوره توسط کاربر',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?>
                <div class="alert alert-secondary">
                    در صورتی که دوره کاربر تمام شود، چه پیامی به او نمایش داده شود
                </div>
                
                <hr>

            </div>
            <!-- -------------------------------------------------->
           
            <div class="tab-pane col-6" id="price" role="price"><br>
                <?php
                $currency = LmsHelper::Predata('currency_list');
                unset($currency['EUR'],$currency['IQD'],$currency['RUB'],$currency['USD']);
                echo $this->Form->control('plugin_lms.currency',[
                    'label'=>'انتخاب واحد پولی',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> $currency,
                    'class'=> 'form-control' ]);?>

                <?php $this->Form->control('plugin_lms.text_price_zero',[
                    'label'=>'متن مبلغ هنگام صفر بودن مبلغ محصول',
                    'class'=> 'form-control' ]);?>
            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="payment" role="payment"><br>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_product" role="_product"><br>
                <?php $this->Form->control('plugin_lms.cart_redirect_after_add',[
                    'label'=>' انتقال به برگه سبد خرید بعد از «افزودن به سبد»',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><hr>

                <?php $this->Form->control('plugin_lms.text_addtocart',[
                    'label'=>'متن پیش فرض "افزودن به سبد خرید"',
                    'class'=> 'form-control' ]);?><br>

                <?php $this->Form->control('plugin_lms.link_addtocart',[
                    'label'=>'لینک پیش فرض "افزودن به سبد خرید"',
                    'placeholder'=>'http://',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?php $this->Form->control('plugin_lms.product_default_image',[
                    'label'=>'تصویر پیش فرض محصولات',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?php $this->Form->control('plugin_lms.product_image_count',[
                    'label'=>'تعداد باکس تصاویر محصول',
                    'type'=>'number',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><hr>

                <?php $this->Form->control('plugin_lms.default_sort',[
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
            <div class="tab-pane col-6" id="factor" role="factor"><br>
                <?= $this->Form->control('plugin_lms.delete_unpaid_factor',[
                    'label'=>'حذف اتوماتیک فاکتورهای پرداخت نشده',
                    'type'=>'select',
                    'options'=>[
                        0 =>'خیر - غیرفعال',
                        1 => 'بله - فعال'
                    ],
                    'class'=> 'form-control' ]);?>
                    <div class="alert alert-secondary">محاسبه و حذف بر اساس تاریخ ثبت فاکتور انجام می شود</div><br>

                <?= $this->Form->control('plugin_lms.delete_unpaid_factor_day',[
                    'label'=>'تعداد روز حذف ',
                    'type'=>'number',
                    'placeholder'=>10,
                    'class'=> 'form-control' ]);?>
                    <div class="alert alert-secondary">در صورت وارد نکردن عدد، 10 روز محاسبه می شود.</div><br>

                <br><br>

            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_order" role="_order"><br>
                <?php $this->Form->control('plugin_lms.order_savestatus',[
                    'label'=>'وضعیت ثبت سفارشات',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> LmsHelper::Predata('order_savestatus'),
                    'class'=> 'form-control' ]);?><br><br>

                <?php $this->Form->control('plugin_lms.enable_guest_checkout',[
                    'label'=>' اجازه ثبت سفارش به مشتری‌ها دهید بدون نیاز به حساب کاربری',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>

                <?php $this->Form->control('plugin_lms.enable_checkout_login_reminder',[
                    'label'=>'به مشتری اجازه دهید در جریان پرداخت به حساب کاربری خود وارد شود',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="_email" role="_email"><br>
                <?php $this->Form->control('plugin_lms.customer_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مشتری پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>

                <?php $this->Form->control('plugin_lms.admin_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مدیریت پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="sms" role="sms"><br>
                
                <div class="alert alert-danger">
                    در صورتی که متن پیامک خالی باشد، این بخش فعال نخواهد بود (کار نخواهد کرد)
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            %family% نام و نام خانوادگی<br>
                            %username% نام کاربری<br>
                            %course_title% نام دوره<br>
                        </div>
                    
                        <?= $this->Form->control('plugin_lms.smstext_10dayexpire',[
                            'label'=>'متن پیامک 10 روز مانده تا منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:150px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            %family% نام و نام خانوادگی<br>
                            %username% نام کاربری<br>
                            %course_title% نام دوره<br>
                        </div>
                        <?= $this->Form->control('plugin_lms.smstext_30dayexpire',[
                            'label'=>'متن پیامک 30 روز مانده تا منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:150px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <div class="col-12"><hr></div>

                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            %family% نام و نام خانوادگی<br>
                            %username% نام کاربری<br>
                            %course_title% نام دوره<br>
                        </div>                
                        <?= $this->Form->control('plugin_lms.smstext_60dayexpire',[
                            'label'=>'متن پیامک 60 روز مانده تا منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:150px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            %family% نام و نام خانوادگی<br>
                            %username% نام کاربری<br>
                            %course_title% نام دوره<br>
                        </div>
                        <?= $this->Form->control('plugin_lms.smstext_expired',[
                            'label'=>'متن پیامک منقضی شده دوره',
                            'type'=>'textarea','style'=>'height:150px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>

                    <div class="col-12"><hr></div>

                    <div class="col-sm-6">
                        <div class="alert alert-primary">
                            %family% نام و نام خانوادگی<br>
                            %username% نام کاربری<br>
                        </div>
                    
                        <?= $this->Form->control('plugin_lms.smstext_nofactor_newuser',[
                            'label'=>'متن پیامک برای کاربرانی که ثبت نام کرده ولی فاکتور ایجاد نکرده اند',
                            'type'=>'textarea','style'=>'height:150px;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_lms.smstext_nofactor_newuser_day',[
                            'label'=>'تعداد روز حذف ',
                            'type'=>'number',
                            'placeholder'=> 10,
                            'class'=> 'form-control' ]);?>
                            <div class="alert alert-secondary">در صورت وارد نکردن عدد، 10 روز محاسبه می شود.</div><br>


                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
                <!-- <hr style="border-color: #7569f1;"> -->

                <div class="row">
                    <?php /* foreach( LmsHelper::Predata('order_status') as $k=>$v):?>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_lms.sms_'.$k,[
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
                    echo $this->Form->control('plugin_lms.payment_redirect',[
                        'label'=>'هدایت به صفحه بعد از پرداخت موفق',
                        'dir'=>'ltr','placeholder'=>'http://',
                        'class'=> 'form-control' ]);?>
                        <div class="alert alert-secondary">
                            بعد از پرداخت ، کاربر به چه صفحه ای هدایت بشود
                        </div>

                    </div>
                </div>
                <br>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        /* $this->Form->setTemplates([
                            'nestingLabel' => '{{hidden}}{{input}}<label {{attrs}} class="pr-1 pl-1">{{text}}</label>',
                            'formGroup' => '{{input}}{{label}}',
                        ]); */
                        
                        echo 'انتخاب درگاه بانکی'.
                        $this->Form->select('plugin_lms.terminal_list', 
                            LmsHelper::Predata('terminal_list'), [
                            //'multiple' => 'checkbox',
                            'empty'=> '-- انتخاب کنید --',
                            'class'=>'form-control',
                            'label'=>'انتخاب درگاه بانکی',
                        ]);?><br>

                        <?php /*  $this->Form->control('plugin_lms.terminal_data1',[
                            'label'=>'کد  درگاه یک',
                            'dir'=>'ltr',
                            'style'=>'font-family: initial;',
                            'class'=> 'form-control' ]); */?><br>

                        <?= $this->Form->control('plugin_lms.merchant_id',[
                            'type'=>'text',
                            'label'=>'Merchant ID',
                            'dir'=>'ltr',
                            'style'=>'font-family: tahoma;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_lms.terminal_key',[
                            'type'=>'text',
                            'label'=>'Terminal Key',
                            'dir'=>'ltr',
                            'style'=>'font-family: tahoma;',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_lms.terminal_id',[
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
<style>
hr {
    border-top: 1px solid var(--primary);
}
</style>
<?php 
echo $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>