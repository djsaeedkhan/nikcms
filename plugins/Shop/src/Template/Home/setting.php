<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
use Shop\Predata;
$predata = new Predata;
?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت فروشگاه
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0"> 
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create(null,['url'=>['plugin'=>'Admin','controller'=>'Options', 'action'=>'SaveSetting']]);
if(count($result)):
    $hsite = unserialize($result['plugin_shop']);
    $this->request->withData('plugin_shop',$hsite);
    @$this->request->data['plugin_shop'] = $hsite;
endif;?>

<div class="card"><div class="card-body">
    <div class="nav-tabs-boxed">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#shop" role="tab" aria-controls="shop" aria-selected="true"> فروشگاه</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="true"> مالی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="false"> محصولات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false"> انبار</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="false"> سفارش</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false"> ایمیل</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false"> پیامک</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#factor" role="tab" aria-controls="factor" aria-selected="false"> فاکتور</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#currency_convert" role="tab" aria-controls="currency_convert" aria-selected="false"> تبدیل قیمت</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#terminal" role="tab" aria-controls="terminal" aria-selected="false"> درگاه بانکی</a>
            </li>
        </ul>
        <div class="tab-content">

            <div class="tab-pane col-6" id="currency_convert" role="stock"><br>
                <h4 class="card-title fw-b">فعال سازی حالت تبدیل قیمت اتوماتیک</h4>
                
                <?= $this->Form->control('plugin_shop.getprice_enable',[
                    'label'=>'وضعیت',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> [
                        0 =>"غیرفعال",
                        1 =>"فعال",
                    ],
                    'class'=> 'form-control mb-2' ]);?>

                <?= $this->Form->control('plugin_shop.getprice_type',[
                    'label'=>'نوع دریافت اطلاعات',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> [
                        "default" =>"بصورت دستی",
                        "persianapi" =>"سایت PersianApi",
                    ],
                    'class'=> 'form-control ltr']);?>
                    
                <?= $this->Form->control('plugin_shop.getprice_token',[
                    'label'=>'توکن دریافت اطلاعات',
                    'type'=>'text',
                    'class'=> 'form-control ltr' ]);?>

                <?= $this->Form->control('plugin_shop.gold_now_price',[
                    'label'=>'قیمت دستی طلا ('.trim(CartHelper::Predata('currency',ShopHelper::Setting('currency'))).')',
                    'type'=>'text',
                    'class'=> 'form-control ltr' ]);?>

            </div>

            <!-- -------------------------------------------------->
            <div class="tab-pane col-sm-8 active" id="shop" role="shop"><br>
                <h4 class="card-title fw-b">آدرس فروشگاه</h4>
                
                <?= $this->Form->control('plugin_shop.store_name',[
                    'label'=>'نام فروشگاه',
                    'class'=> 'form-control']);?><br>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_shop.store_province',[
                            'label'=>'استان',
                            'type'=>'select',
                            'empty'=>'-- انتخاب کنید --',
                            'options'=> $this->Func->province_list(),
                            'class'=> 'form-control']);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_shop.store_city',[
                            'label'=>'شهر',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                </div>

                <?= $this->Form->control('plugin_shop.store_address',[
                    'label'=>'آدرس کامل',
                    'type'=>'textarea',
                    'class'=> 'form-control' ]);?><br>
                
                <?= $this->Form->control('plugin_shop.store_zipcode',[
                    'label'=>'کدپستی',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><br><hr>
                
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_shop.sh_meli',[
                            'label'=>'شناسه ملی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_shop.sh_sabt',[
                            'label'=>'شماره ثبت',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_shop.sh_eghtesadi',[
                            'label'=>'شماره اقتصادی',
                            'type'=>'text',
                            'class'=> 'form-control form-control-sm1 ltr']);?>
                    </div>
                </div><hr><br>


                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_shop.phone',[
                            'label'=>'شماره موبایل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'09',
                            'class'=> 'form-control' ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_shop.email',[
                            'label'=>'آدرس ایمیل پیشفرض',
                            'dir'=>'ltr',
                            'placeholder'=>'....[@]....[.]com',
                            'class'=> 'form-control' ]);?>
                    </div>
                    
                </div><hr>
            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="stock" role="stock"><br>
                <h4 class="card-title fw-b">موجودی انبار</h4>
                
                <?= $this->Form->control('plugin_shop.stock_show',[
                    'label'=>'نمایش تعداد موجودی در صفحه محصول',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?>

            </div>
            <!-- -------------------------------------------------->
            <div class="tab-pane col-6" id="price" role="price"><br>

                <h4 class="card-title fw-b">پیکربندی وزن </h4>
                <?= $this->Form->control('plugin_shop.weight_unit',[
                    'label'=>'انتخاب واحد اندازه گیری پیشفرض',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=>  $predata->gettype('weight_unit'),
                    'class'=> 'form-control' ]);?><br><hr><br>

                <h4 class="card-title fw-b">پیکربندی واحد پولی</h4>
                <?= $this->Form->control('plugin_shop.currency',[
                    'label'=>'انتخاب واحد پولی',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> CartHelper::Predata('currency_list'),
                    'class'=> 'form-control' ]);?><Br><Br>

                <?= $this->Form->control('plugin_shop.text_price_zero',[
                    'label'=>'متن مبلغ هنگام صفر بودن مبلغ محصول',
                    'class'=> 'form-control' ]);?>

                <br><hr><br>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="product" role="product"><br>
                <?= $this->Form->control('plugin_shop.cart_redirect_after_add',[
                    'label'=>' انتقال به برگه سبد خرید بعد از «افزودن به سبد»',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><hr>

                <?= $this->Form->control('plugin_shop.text_addtocart',[
                    'label'=>'متن پیش فرض "افزودن به سبد خرید"',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_shop.link_addtocart',[
                    'label'=>'لینک پیش فرض "افزودن به سبد خرید"',
                    'placeholder'=>'http://',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?= $this->Form->control('plugin_shop.product_default_image',[
                    'label'=>'تصویر پیش فرض محصولات',
                    'class'=> 'form-control ltr' ]);?><hr>

                <?= $this->Form->control('plugin_shop.product_image_count',[
                    'label'=>'تعداد باکس تصاویر محصول',
                    'type'=>'number',
                    'dir'=>'ltr',
                    'class'=> 'form-control' ]);?><hr>

                <?= $this->Form->control('plugin_shop.default_sort',[
                    'label'=>'سورت پیش فرض محصولات',
                    'type'=>'select','empty'=>' -- انتخاب کنید -- ',
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
                <?= $this->Form->control('plugin_shop.factor_title1',[
                    'label'=>'پرینت فاکتور -  عنوان اول',
                    'type'=>'text',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_shop.factor_title2',[
                    'label'=>'پرینت فاکتور -  عنوان دوم',
                    'class'=> 'form-control' ]);?><br>
                    
                <?= $this->Form->control('plugin_shop.factor_tapimg',[
                    'label'=>'تصویر مهر و امضا',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>

                <?= $this->Form->control('plugin_shop.factor_logo',[
                    'label'=>'تصویر لوگو',
                    'type'=>'text',
                    'dir'=>'ltr',
                    'placeholder'=>'http://',
                    'class'=> 'form-control' ]);?><br>
                    
                <br><br>

            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="order" role="order"><br>
                <?= $this->Form->control('plugin_shop.order_savestatus',[
                    'label'=>'وضعیت ثبت سفارشات',
                    'type'=>'select',
                    'empty'=>'-- انتخاب کنید --',
                    'options'=> CartHelper::Predata('order_savestatus'),
                    'class'=> 'form-control' ]);?><br><br>

                <?= $this->Form->control('plugin_shop.enable_guest_checkout',[
                    'label'=>' اجازه ثبت سفارش به مشتری‌ها دهید بدون نیاز به حساب کاربری',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>

                <?= $this->Form->control('plugin_shop.enable_checkout_login_reminder',[
                    'label'=>'به مشتری اجازه دهید در جریان پرداخت به حساب کاربری خود وارد شود',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-6" id="email" role="email"><br>
                <?= $this->Form->control('plugin_shop.customer_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مشتری پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1']);?><br>

                <?= $this->Form->control('plugin_shop.admin_sendemail_after_order',[
                    'label'=>' ارسال ایمیل به مدیریت پس از ثبت سفارش',
                    'type'=>'checkbox',
                    'class'=> 'form-control1' ]);?><br>
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="sms" role="sms"><br>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_shop.default_mobile',[
                            'label'=>'شماره موبایل پیش فرض پیامک',
                            'placeholder'=>'09...',
                            'class'=> 'form-control ltr' ]);?><br>
                    </div>
                </div>
                <hr style="border-color: #7569f1;">

                <div class="row">
                    <div class="col-sm-6">
                        <?= $this->Form->control('plugin_shop.customer_sendesms',[
                            'label'=>' مشتری - ارسال پیامک ',
                            'type'=>'checkbox',
                            'class'=> 'form-control1' ]);?><br>

                        <?= $this->Form->control('plugin_shop.customer_sendesms_order_save',[
                            'label'=>' مشتری - پیامک ثبت سفارش',
                            'type'=>'textarea',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_shop.customer_sendesms_order_paid',[
                            'label'=>' مشتری - پیامک ثبت پرداخت',
                            'type'=>'textarea',
                            'class'=> 'form-control' ]);?><br>
                    </div>

                    <div class="col-sm-6">
                    
                        <?= $this->Form->control('plugin_shop.admin_sendesms',[
                            'label'=>' مدیریت - ارسال پیامک',
                            'type'=>'checkbox',
                            'class'=> 'form-control1' ]);?><br>

                        <?= $this->Form->control('plugin_shop.admin_sendesms_order_save',[
                            'label'=>' مدیریت - پیامک ثبت سفارش',
                            'type'=>'textarea',
                            'class'=> 'form-control' ]);?><br>

                        <?= $this->Form->control('plugin_shop.admin_sendesms_order_paid',[
                            'label'=>' مدیریت - پیامک ثبت پرداخت',
                            'type'=>'textarea',
                            'class'=> 'form-control' ]);?><br>
                        
                    </div>
                </div>

                <hr style="border-color: #7569f1;">
                <h2 class="badge badge-primary" style="font-size:20px;">مدیریت متن پیامک های "وضعیت سفارش"</h2>
                <div class="alert alert-secondary">
                    این پیامک ها پس از تغییر وضعیت سفارش توسط اوپراتور، به مشتری ارسال خواهند شد
                </div>
                <div class="row">
                    <?php foreach( CartHelper::Predata('order_status') as $k=>$v):?>
                    <div class="col-sm-4">
                        <?= $this->Form->control('plugin_shop.sms_'.$k,[
                            'label'=>$v,
                            'type'=>'textarea','style'=>'height:100px;',
                            'class'=> 'form-control' ]);?><br>
                    </div>
                    <?php endforeach?>
                    
                </div>
                
            </div>
            <!-- -------------------------------------------------->

            <div class="tab-pane col-12" id="terminal" role="terminal"><br>
                
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        $this->Form->setTemplates([
                            'checkboxWrapper' => '<div class="checkbox-wrapper">{{label}}</div>',
                            'nestingLabel' => '{{hidden}}{{input}} <label {{attrs}} class="pr-1 pl-1">{{text}}</label>',
                            'formGroup' => '{{input}}{{label}}',
                            

                            'formStart' => '<form{{attrs}}>',
                            'formEnd' => '</form>',
                            //'formGroup' => '{{label}}{{input}}',
                            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}>',
                            'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
                            'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
                            'selectOption' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
                            'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
                            'radio' => '{{content}}',
                            'radioWrapper' => '<div class="radio">{{label}}</div>',
                            //'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                            //'label' => '<label{{attrs}}>{{text}}</label>',
                            'inputContainer' => '<div class="input {{type}}">{{content}}</div>',
                            'inputContainerError' => '<div class="input {{type}} error">{{content}}{{error}}</div>',
                            'error' => '<div class="error-message">{{content}}</div>',
                            'submitContainer' => '<div class="submit">{{content}}</div>',
                            'button' => '<button{{attrs}}>{{text}}</button>',
                            'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
                            'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
                            'legend' => '<legend>{{text}}</legend>',
                            'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
                            'inputSubmit' => '<input type="submit"{{attrs}}>',
                            'confirmJs' => 'if (confirm("{{message}}")) { return true; } else { return false; }',
                        ]);
                        
                        echo 'انتخاب درگاه بانکی'.
                        $this->Form->select('plugin_shop.terminal_list', 
                            CartHelper::Predata('terminal_list'), [
                            'multiple' =>false,
                            'templateVars' => [
                                'selected' => ' checked="checkedss"'
                            ],
                            'class'=>'form-control',
                            'label'=>'انتخاب درگاه بانکی',
                        ]);

                        // بازگرداندن قالب‌های پیش‌فرض (برای سایر فرم‌ها)
                        $this->Form->setTemplates([
                            'nestingLabel' => '<label{{attrs}}>{{hidden}}{{input}}{{text}}</label>',
                            'formGroup' => '{{label}}{{input}}',
                        ]);
                        ?><br>
                        
                        <?= $this->Form->control('plugin_shop.terminal_id',[
                            'label'=>'کدپذیرنده / کد ترمینال / مرچنت ',
                            'type'=>'text',
                            'dir'=>'ltr',
                            'style'=>'font-family: initial;',
                            'class'=> 'form-control' ]);?><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('plugin_shop.usercode',[
                                    'label'=>'نام کاربری',
                                    'dir'=>'ltr',
                                    'style'=>'font-family: initial;',
                                    'class'=> 'form-control' ]);?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('plugin_shop.passcode',[
                                    'label'=>'رمز عبور',
                                    'dir'=>'ltr',
                                    'style'=>'font-family: initial;',
                                    'class'=> 'form-control' ]);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="alert alert-info">
                            بخش مورد نظر را کامل کنید
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
label.selected {
    padding-right: 1rem !important;
}
</style>
<?php 
echo $this->Form->submit('ذخیره تغییرات',['class'=>'btn btn-success col-xs-3 mb-3']);
echo $this->Form->end();?>