<?php
use Cake\I18n\Time;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
$pp = new Shop\ProvinceCity();
//pr($order_detail);?>
<?php $this->assign('shop_title','نمایش جزئیات سفارش #'.$order_id)?>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-body mb-3" style="font-size: 13px;line-height: 30px;">
            <strong>تحویل محصول به مشتری:</strong>
            <?php if($order_detail['enable'] < 1):?>
            در صورتی که خدمات به مشتری به پایان رسیده است و محصول با موفقیت به مشتری تحویل داده شده، کلید تحویل نهایی محصول را بزنید
            <?php
                echo $this->Form->create(null,);
                echo $this->Form->control('action',[
                    'value'=>'done',
                    'type'=>'hidden']);
                echo $this->Form->button(__('تحویل نهایی محصول'),[
                    'style'=>'font-size:13px;',
                    'confirm'=>'آیا مطمین هستید؟',
                    'class'=>'btn btn-outline-success btn-sm mb-3']);
                echo $this->Form->end() ?>
            <?php else:?>
                <div class="text-success">این محصول با موفقیت تحویل داده شده است.</div>
            <?php endif?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-body mb-3" style="font-size: 13px;line-height: 30px;">
            <strong>مشخصات مشتری</strong>
            <?php if(isset($order_detail['user']['id'])):?>
                <div>نام و نام خانوادگی: <?= $order_detail['user']['family']?></div>
                <div>نام کاربری:  <?= $order_detail['user']['username']?></div>
                <div>آدرس ایمیل:  <?= $order_detail['user']['email']?></div>
            <?php else: echo 'متاسفانه مشخصات کاربر پیدا نشد';endif;?>
            <div>آدرس: <?php
                if(isset($order_detail['shop_order']['shop_address']['shop_useraddress']['billing_state'])){
                    $address = $order_detail['shop_order']['shop_address']['shop_useraddress'];
                    echo $this->Func->province_list($address['billing_state']) .' - '. 
                        $pp->getlist($address['billing_state'],$address['billing_city']) . ' - '. 
                        $address['billing_address'];
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">

        <div class="card card-body" style="font-size: 13px;line-height: 30px;">
            <strong>مشخصات سفارش</strong>
            <?php if(isset($order_detail['shop_orderproduct']['id'])):?>
                <div>شماره سفارش: <?= $order_detail['shop_order']['id']?></div>
                <div>کدپیگیری: <?= $order_detail['shop_order']['trackcode']?></div>
                <div>نام محصول: <?= $order_detail['shop_orderproduct']['name']?></div>
                <div>تعداد سفارش :  <?= $order_detail['shop_orderproduct']['quantity']?></div>
            <?php else: 
                echo 'متاسفانه مشخصات کاربر پیدا نشد';
            endif;?>
        </div>
    </div>

    <?php if($order_detail['enable'] < 1):?>
        <div class="col-sm-12 mb-3">
            <div class="card card-body" style="font-size: 13px;line-height: 30px;">
                <strong class="pb-2">ثبت وضعیت جدید</strong>
                <?php
                    echo $this->Form->create(null);
                    echo $this->Form->control('descr',[
                        'class'=>'form-control',
                        'label'=>false,
                        'placeholder'=>'متن توضیحات',
                        'type'=>'textarea']);
                    echo $this->Form->button(__('ثبت اطلاعات'),[
                        'style'=>'font-size:13px;',
                        'class'=>'mt-2 btn btn-sm btn-success']);
                    echo $this->Form->end() ?>
                
            </div>
        </div>
    <?php endif?>

    <div class="col-sm-12">
        <div class="card card-body" style="font-size: 13px;line-height: 30px;">
            <strong>لیست وضعیت ها</strong>
            
            <?php 
            if( isset($order_detail['shop_orderlogesticlogs']) ):
                echo '<ul style="list-style-position: inside;">';
                    foreach($order_detail['shop_orderlogesticlogs'] as $log):
                        echo '<li style="display: block;line-height: 26px;">';
                        echo '<div class="small" style="display: flex;justify-content: space-between;"><div>اقدام کننده: '.
                        $log['user']['username'].($log['user']['family']!=""?' ('.$log['user']['family'].')':'').'</div><div>'.$this->Func->date2($log['created']).'</div></div>';
                        echo $log['descr'];
                        echo '<hr></li>';
                    endforeach;
                echo '</ul>';
            endif?>
        </div>
    </div>

    
</div>


<style>
    .postcontent{
        border:0 !important;
        padding:0 !important;
    }
    .postcontent .card-body{
        border: 1px solid #ededed;
    }
    .postcontent form{
        margin:0;
    }
</style>