<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
use Cake\Routing\Router;
?>

<div class="modal1 mfp-hide" id="myModal1">
    <div class="block mx-auto" style="background-color: #FFF; max-width:700px;">
        <div class="text-center" style="padding: 20px;">
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
            <iframe src="<?= Router::url('/shop/profile/addresses/?nonav=1')?>" width="500" height="310" allow="fullscreen" ></iframe>
        </div>
    </div>
</div>
<style>
    .mfp-auto-cursor > .mfp-close{
        display:none;
    }
    .modal1 button.mfp-close{
        color: #000;
        right: inherit;
        margin-right: -20px;
        margin-top: -5px;
    }
</style>

<section id="content" dir="rtl" class="text-right">
    <div class="content-wrap pt-4 pb-1" style="overflow: visible;">
        <div class="container">
            <?php $progress = 'cart';include_once('progress.php')?>
        </div>
		<div class="container">
            
            <?php if(empty($shop)) : ?>
                <h2 class="text-right mb-2">سبد خرید</h2>
                <div class="alert alert-info text-center">سبدخرید شما خالی می باشد</div>
            <?php else: ?>

            <div class="row">
                <div class="col-sm-9">
                    <?= $this->Form->create(null, ['url' => '/product/cart/cartupdate/add']); ?>

                    <?php $tabindex = 1;$i=1;
                    foreach (array_reverse($shop['Orderproducts']) as $key => $item):
                        $result = [];
                        if(isset($item['product_id']) and $item['product_id'] != ''){
                            $result = $this->Query->post(null,['id' => $item['product_id'],'get_type'=>'first']);
                        }?>

                            <div class="card" id="row_<?= $item['product_id'];?>"><div class="card-body">
                                <div>
                                    <div style="float:right;margin-left: 20px;">
                                        <?= $this->html->image( 
                                            ($item['image'] !=''?$item['image']:$shop_setting['product_default_image']), ['class'=>'img-thumbnail','style'=>'max-width:120px;max-heigth:120px;']); ?>
                                    </div>
                                    <div class="px-2 px-sm-2">
                                        <div>
                                            <strong><a href="<?= $this->Query->the_permalink(['id'=>$item['product_id'] ]); ?>">
                                                <?= $result['title']?>
                                            </a></strong>

                                            <?php 
                                            if(isset($item['attrlist']) and count($item['attrlist'])){
                                                foreach($item['attrlist'] as $kitm => $itm){
                                                    echo $itm != ''?'<div class="small">'.$kitm.' : '.$itm.'</div>' : '';
                                                }
                                            }?>
                                        </div>

                                        <div>
                                            قیمت: <?= ShopHelper::PriceShow($item['price']);?>
                                        </div><br>

                                        <div class="d-flex" style="align-items: center;">
                                            <div class="d-flex" style="align-items: center;">
                                                <?= $this->Form->control('qty' . $key, [
                                                    'label' => false,
                                                    'class' => 'numeric form-control input-small', 
                                                    'type' => 'tel',
                                                    'size'=> 3, 
                                                    'min' => 1, 
                                                    'max' => 999, 
                                                    'maxlength' => 3,
                                                    'style'=>'max-width:70px;', 
                                                    'value' => $item['quantity']]); ?>
                                                <?= $this->Form->button('بروز رسانی', [
                                                    'title'=>'بروز رسانی سبد خرید','id'=>'btn_refresh','class'=>'d-none',
                                                    'escape' => false]);?>
                                                <?php echo $this->Html->link('<i class="icon-trash2 fs-20"></i>', '/product/cart/remove/'.$key, [
                                                    'confirm' =>'برای حذف مطمئن هستید؟',
                                                    'class' => 'text-danger px-2', 'escape' => false]); ?>
                                            </div>
                                            <div id="subtotal-<?=$key; ?>" class="px-2">
                                                <?= ShopHelper::PriceShow($item['subtotal']);?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div></div>
                        <?php endforeach; ?>
                        <br>

                    <script nonce="<?=get_nonce?>">
                        $('.numeric').on('input', function() {
                            $(this).parent().find('#btn_refresh').removeClass('d-none');
                            $('#btn_refresh').removeClass('d-none');
                        });
                    </script>
                    <?= $this->Form->end(); ?>
                </div>

                <div class="col-sm-3">
                    <div class="card mb-2"><div class="card-body">
                        <div class="d-flex mb-3" style="justify-content: space-between;">
                            <div>تعداد سفارش :</div>
                            <div>
                                <span class="nor1mal">
                                    <?= count($shop['Orderproducts']);?> کالا
                                </span>
                            </div>
                        </div>

                        <div class="d-flex" style="justify-content: space-between;">
                            <div>جمع فاکتور:</div>
                            <div>
                                <span class="nor1mal" id="subtotal">
                                    <?= ShopHelper::PriceShow($shop['Order']['subtotal']);?>
                                </span>
                            </div>
                        </div>

                        
                        <?php
                        if(! $this->request->getAttribute('identity')->get('id') ){
                            echo '<br> <br>'.$this->html->link('تایید و  تکمیل سفارش',
                            '#modal-login-form',[
                                'data-bs-target'=>'#loginRegisterModal',
                                'data-bs-toggle'=> 'modal',
                                "class"=>"button btn-sm button-primary d-block text-center",
                                'style'=>'font-size:13px;background:#fb373e']);
                        }
                        ?>
                    </div></div>

                    <!-- <div class="d-flex mt-3" style="justify-content: space-between;">
                        <div>
                        <?= $this->Html->link('حذف سبدخرید', 
                        '/product/cart/clear/empty', [
                            'title'=>'پاک کردن سبدخرید',
                            'style'=>'vertical-align: inherit;font-size: 12px;',
                            'class' => 'btn btn-outline-danger btn-sm mb-1', 'escape' => false]); ?>
                        </div>
                        <div>
                        <?= $this->Form->button('<i class="fa fa-calculator"></i> &nbsp; بروزرسانی سبدخرید', [
                            'class' => 'btn btn-outline-secondary btn-sm',
                            'style'=>'font-size: 12px;',
                            'title'=>'بروز رسانی سبدخرید',
                            'escape' => false]);?>
                        </div>
                    </div> -->
                    <p class="fs-12 text-center">هزینه این سفارش هنوز پرداخت نشده‌ و در صورت اتمام موجودی، کالاها از سبد حذف می‌شوند</p>

                </div>
            </div>
            



            <!-- ----------------------------------------------------------- -->
            <?php
            if( $this->request->getAttribute('identity')->get('id') ){
                
            echo $this->Form->create($shopAddress,['id'=>'forms']);?>
            <div class="row">
                <div class="col-sm-12 mb-5"><div class="row">
                    <div class="col-sm-6">

                        <h3 class="text-right">آدرس تحویل مرسوله</h3>
                        <div class="row"><div class="col-12">
                            <?php
                            $pp = new Shop\ProvinceCity();
                            if(count($user_address)){
                                $i=0;
                                foreach($user_address as $usera){
                                    echo '<div class="useraddress useraddresss text-left" style="border: 0;background:#FFF;margin-bottom:10px;">';
                                    echo $this->form->radio('shop_useraddress_id.',
                                        [$usera['id'] => $this->Func->province_list($usera['billing_state']).' - '.
                                        $pp->getlist($usera['billing_state'],$usera['billing_city'])
                                        .' - '.$usera['billing_address'].' - '.$usera['billing_zip']],
                                        ['style'=>'margin-left:10px;',
                                        'required',($i==0?'checked':false),
                                        'oninvalid'=>"this.setCustomValidity('Enter User Name Here')",
                                        'oninput'=>"this.setCustomValidity('')",
                                        'disable'=>false ]);
                                    echo '</div>';
                                    $i++;
                                }
                            }
                            else{
                                echo '<div class="alert alert-dark border-0">آدرس شما هنوز ثبت نشده است.</div>';
                            }?> 
                            
                            <div class="col-12" style="text-align: right;">
                                <?php
                                if( $this->request->getAttribute('identity')->get('id') ){
                                echo $this->html->link('افزودن / ویرایش آدرس ها',
                                    '#myModal1',[ 'data-lightbox'=>"inline",
                                    "class"=>"btn btn-sm btn-primary",
                                    'style'=>'font-size:13px;']);
                                }
                                else{
                                    echo $this->html->link('+',
                                    '#modal-login-form',[
                                        'data-bs-target'=>'#loginRegisterModal',
                                        'data-bs-toggle'=> 'modal',
                                        "class"=>"btn btn-sm btn-primary",
                                        'style'=>'font-size:13px;']);
                                }
                                ?>
                            </div>
                        </div></div>
                            
                    </div>

                    <div class="col-sm-6 rtl text-right">
                        
                        <div class="custom-control custom-checkbox dlistbutton">
                            <input type="checkbox" name="a11" class="custom-control-input" id="another"  />
                            <label class="custom-control-label" for="another">
                                <h4 class="mb-0" style="font-size:15px;font-weight:normal;letter: spacing 0;">ثبت گیرنده دیگر</h4>
                            </label>
                        </div>

                        <script nonce="<?=get_nonce?>">
                        $(document).on('click', '#another', function () {
                            if ($('#another').is(':checked')) {
                                $('.another_box').removeClass('d-none');
                                $(".another_box input").prop('required',true);
                                $(".another_box #ao_email").prop('required',false);
                            }
                            else{
                                $('.another_box').addClass('d-none');
                                $(".another_box input").prop('required',false);
                                //$(".useraddresss input").prop('required',true);
                            }
                        });
                        </script>

                        <div class="another_box d-none alert alert-warning">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $this->form->control('another.name',[
                                        "data-toggle"=>"tooltip",
                                        "data-placement"=>"top",
                                    // "title"=>"ضروری",
                                        'oninvalid'=>"this.setCustomValidity('اجباری')",
                                        'oninput'=>"setCustomValidity('')",
                                        'label'=>'نام *','id'=>'ao_name',
                                        'class'=>'form-control mb-1'])?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->form->control('another.family',[
                                        'label'=>'نام خانوادگی *','id'=>'ao_family',
                                        "data-toggle"=>"tooltip",
                                        "data-placement"=>"top",
                                        //"title"=>"ضروری",
                                        'oninvalid'=>"this.setCustomValidity('اجباری')",
                                        'oninput'=>"setCustomValidity('')",
                                        'class'=>'form-control mb-1'])?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->form->control('another.phone',[
                                        "data-toggle"=>"tooltip",
                                        "data-placement"=>"top",
                                        //"title"=>"ضروری",
                                        'oninvalid'=>"this.setCustomValidity('اجباری')",
                                        'oninput'=>"setCustomValidity('')",
                                        'label'=>'شماره موبایل *','dir'=>'ltr','id'=>'ao_phone',
                                        'class'=>'form-control mb-1','placeholder'=>'09...'])?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->form->control('another.nationalid',[
                                        "data-toggle"=>"tooltip",
                                        "data-placement"=>"top",
                                        //"title"=>"ضروری",
                                        'oninvalid'=>"this.setCustomValidity('اجباری')",
                                        'oninput'=>"setCustomValidity('')",
                                        'label'=>'کدملی *','dir'=>'ltr','id'=>'ao_nationalid',
                                        'class'=>'form-control mb-1'])?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $this->form->control('another.email',[
                                        'label'=>'آدرس ایمیل','type'=>'email','dir'=>'ltr','id'=>'ao_email',
                                        'class'=>'form-control mb-1','placeholder'=>'...@...'])?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div></div>

                <div class="col-sm-12">
                    <h3 class="text-right">روش ارسال سبدخرید برای شما
                        <span style="font-size: 14px;font-weight: normal;"> (پرداخت در مرحله بعد انجام میگردد)</span>
                    </h3>
                    <div class="row">
                        <?php
                        $i=0;
                        foreach(CartHelper::ShippingList('enabled') as $k_ps => $v_ps){
                            if($v_ps['enable'] == 1){
                                echo '<div class="col-sm-4"><div class="alert alert-light useraddress tmpclass1" style="min-width: 25%;text-align:right !important;">';
                                echo $this->form->radio('shipping.types.',
                                    [$v_ps['slug'] => ($v_ps['image'] != ""?$this->html->image($v_ps['image'],
                                        ['style'=>'display: block;height:50px;margin-bottom:10px;']):'').
                                        $v_ps['title'] 
                                    ],
                                    ['style'=>'margin-left:10px;text-align:center','escape'=>false,//'required',
                                    ($i==0?'checked':false),
                                    //'oninvalid'=>"this.setCustomValidity('لطفا روش ارسال مورد نظر را انتخاب کنید')",
                                    //'oninput'=>"this.setCustomValidity('')",
                                ]);
                                echo (isset( $v_ps['descr'] ) and $v_ps['descr'] != '')?'<br><b style="font-size: 13px;">'.$v_ps['descr'].'</b>':'';
                                echo '</div></div>';
                                $i++;
                            }
                        }?>
                    </div>
                </div>

            </div>
            
            <?= $this->form->button('<i class="icon-angle-right shp_icn"></i> تایید و  تکمیل سفارش', 
                ['class' => 'btn btn-success btn-sm float-right','style'=>'background:#fb373e;border:0', 'escape' => false]); ?>

            <div class="clearfix"></div><br><br>

            <?= $this->Form->end();
            }?>
            <?php endif; ?>
            
        </div>
    </div>
</section>
<style>
#btn_refresh{
    border: 0;
    background: none;
    font-size: 13px;
    margin-top: 10px;
}
</style>