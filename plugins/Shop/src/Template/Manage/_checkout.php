<?php
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Shop\Predata;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
$predata = new Predata;?>



<section id="content">
	<div class="content-wrap pt-4 clearfix">
		<div class="container">
            <?= $this->Form->create($shopAddress);?>
            <h3 class="text-right">
                مشخصات تحویل
                <div style="display: initial;">
                    <?= $this->html->link('ویرایش اطلاعات کاربر',
                        '/product/checkout/profile',
                        ['class'=>'btn btn-warning btn-sm','style'=>'font-size:14px;'])?>
                </div>
            </h3>
            <div class="row text-right rtl" style="font-size:14px;">
                <div class="col col-sm-4">
                    <?= $this->Form->control('first_name', [
                        'label'=>'نام',
                        'default'=>isset($shop_profile['name'])?$shop_profile['name']:false,
                        'class' => 'form-control']);?><br />

                    <?= $this->Form->control('last_name', [
                        'label'=>'نام خانوادگی',
                        'default'=>isset($shop_profile['family'])?$shop_profile['family']:false,
                        'class' => 'form-control']); ?><br />
                </div>
                <div class="col col-sm-4">
                    <?= $this->Form->control('nationalid',[
                        'label'=>'کدملی',
                        'dir'=>'ltr',
                        'default'=>isset($shop_profile['nationalid'])?$shop_profile['nationalid']:false,
                        'class' => 'form-control']);?><br />

                    <?= $this->Form->control('phone',[
                        'label'=>'شماره تلفن همراه',
                        'default'=>isset($shop_profile['phone'])?$shop_profile['phone']:false,
                        'dir'=>'ltr','class' => 'form-control']); ?><br />

                    <?= $this->Form->control('emails', [
                        'label'=>'آدرس ایمیل',
                        'default'=>isset($shop_profile['email'])?$shop_profile['email']:false,
                        'dir'=>'ltr',
                        'class' => 'form-control']);?><br />
                </div>
                <div class="col col-sm-4">
                    <?= $this->Form->control('billing_desc', [
                        'rows'=>'8',
                        'type'=>'textarea','label'=>'توضیحات سفارش','class' => 'form-control']); ?><br />
                </div>
            </div><br /><br/>
            <div>
            <!--- ---------------->
            <div class="clearfix"></div><br><br>
            <?= $this->Form->button('<i class="icon-angle-right shp_icn"></i>مرحله بعد : پیش فاکتور', 
                ['class' => 'btn btn-success btn-sm float-right','style'=>'width: 180px;','escape'=>false]);?>
            <?= $this->html->link('مرحله قبل : سبدخرید <i class="icon-angle-left shp_icn"></i> ',
                '/product/cart',
                ['class' => 'btn btn-warning btn-sm float-left','escape'=>false]);?>
            <?= $this->Form->end(); ?>
            <!-- ----------------------------------------------------------- -->
            <!-- ----------------------------------------------------------- -->
            <!-- ----------------------------------------------------------- -->
        </div>
    </div>
</section>