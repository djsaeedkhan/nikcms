<?php
use Admin\View\Helper\FuncHelper;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
$pp = new Shop\ProvinceCity();
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>فاکتور فروش</title>
</head>
<body>
<button class="print-button" id="print-button">پرینت</button>
<div class="page">
    <h1 style="text-align: center;">
        <?=($setting['factor_title1'] != ''?$setting['factor_title1']:'عنوان اول')?>
    </h1>
    <table class="header-table" style="width: 100%">
        <tbody><tr>
            <td style="width: 1.8cm; height: 2.5cm;vertical-align: middle;padding-bottom: 4px;">
                <div class="header-item-wrapper">
                    <div class="portait portrait1">حق‌العمل کار</div>
                </div>
            </td>
            <td style="padding: 0 4px 4px;height: 2cm;">
                <div class="bordered grow header-item-data">
                    <table class="grow centered">
                        <tbody><tr>
                                <td style="width: 7cm">
                                    <span class="label">فروشنده:</span> <?= $setting['store_name']?>
                                </td>
                                <td style="width: 5cm">
                                    <span class="label">شناسه ملی:</span> <?= $setting['sh_meli']?>
                                </td>
                                <td>
                                    <span class="label">شماره ثبت:</span> <?= $setting['sh_sabt']?>
                                </td>
                                <td>
                                    <span class="label">شماره اقتصادی:</span> <?= $setting['sh_eghtesadi']?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="label">نشانی شرکت:</span>
                                    <?= $this->Func->province_list($setting['store_province']).' - '. $setting['store_city'].' - '?>
                                    <?= $setting['store_address']?>
                                </td>
                                <td>
                                    <span class="label">کدپستی:</span> <?= $setting['store_zipcode']?>
                                </td>
                                <td>
                                    <span class="label">تلفن و فکس:</span> <?= $setting['phone'] . ' / '.$setting['email']?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width: 4.5cm;height: 2cm;padding: 0 0 4px;">
                <div class="bordered grow" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div class="font-small">شماره فاکتور:</div>
                        <div class="flex-grow" style="text-align: left"><?= $results['id']?></div>
                    </div>
                    <div class="barcode">
                        <span>#</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 1.8cm; height: 2cm;vertical-align: center; padding: 0 0 4px">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin: 20px">خریدار</div>
                </div>
            </td>
            <td style="height: 2cm;vertical-align: center; padding: 0 4px 4px">
                <?php 
                $address_u = isset($results['shop_address']['shop_useraddress'])?$results['shop_address']['shop_useraddress']:null;
                $address   = isset($results['shop_address'])?$results['shop_address']:null;
                if( $address != null):?>
                <div class="bordered header-item-data">
                    <table style="height: 100%" class="centered">
                        <tbody>
                            <tr>
                                <td style="width: 6.7cm">
                                    <span class="label">خریدار:</span> <?= $address['first_name'] .' ' . $address['last_name']?>
                                </td>
                                <td style="width: 6.7cm">
                                    <span class="label">شماره‌اقتصادی / شماره‌ملی:</span> <?= $address['nationalid']?>
                                </td>
                                <td>
                                    <span class="label">شناسه ملی:</span> <?= $address['nationalid']?>
                                </td>
                                <td>
                                    <span class="label">شماره ثبت:</span> -
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <span class="label">نشانی:</span> <?= 
                                    $this->Func->province_list($address_u['billing_state']) .' - '.
                                    $pp->getlist($address_u['billing_state'],$address_u['billing_city']) .' - '.
                                    $address_u['billing_address'];?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="label">شماره تماس: </span> <?= $address['phone'] . ' / '.$address['emails']?>
                                </td>
                                <td colspan="2">
                                    <span class="label">کد پستی:</span> <?= $address_u['billing_zip']?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif?>
            </td>
            <td style="padding: 0 0 4px">
                <div class="grow bordered" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div>تاریخ:</div>
                        <div class="flex-grow" style="text-align: left">
                            <?= isset($results['created'])?$this->Func->mil_to_shm($results['created']->format('Y-m-d')):''?>
                        </div>
                    </div>
                    <div class="flex">
                        <div>پیگیری:</div>
                        <div class="flex-grow font-medium" style="text-align: left"><?= $results['trackcode']?></div>
                    </div>
                    <div class="barcode">
                        <span>#</span>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
    
    <table class="content-table">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>شناسه کالا یا خدمت</th>
                <th style="width: 30%">شرح کالا یا خدمت</th>
                <th>آمر</th>
                <th>تعداد</th>
                <th style="width: 2.3cm">مبلغ واحد (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">مبلغ کل (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">تخفیف (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">مبلغ کل پس از تخفیف (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm"> جمع مالیات و عوارض ارزش افزوده (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.5cm"> جمع کل پس از تخفیف و مالیات و عوارض (<?=ShopHelper::CurrencyShow()?>)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $i=1;
            if(isset($results['shop_orderproducts'])):
            foreach($results['shop_orderproducts'] as $item):?>
            <tr>
                <td><?=$i++?></td>
                <td><?= $item['post_id']?></td>
                <td style="text-align: right;">
                    <?= $item['name']?>
                    <?php if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                        foreach($item['shop_orderattributes'] as $itm)
                            echo '<div class="small">'.
                                (isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                                (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-').'</div>';
                    }?>
                </td>
                <td><span>--</span></td>
                <td><span class="ltr"><?= $item['quantity']?></span></td>
                <td><span class="ltr"><?= number_format(intval($item['price']))?></span></td>
                <td><span class="ltr"><?= number_format(intval($item['subtotal']))?></span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
            </tr>
            <?php 
            $total+=$item['subtotal'];
            endforeach;endif;?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                </td><td colspan="3" class="font-small">
                    جمع کل پس از تخفیف و کسر مالیات و عوارض (<?=ShopHelper::CurrencyShow()?>):
                </td>
                <td><span class="ltr"><?= number_format(intval($total)); //ShopHelper::PriceShow($total )?></span></td>
            </tr>
            <tr style="background: #fff">
                <td colspan="11" style="height: 2.5cm;vertical-align: top">
                    <div class="flex">
                        <div class="flex-grow">مهر و امضای فروشنده:</div>
                        <div class="flex-grow">تاریخ تحویل:</div>
                        <div class="flex-grow">ساعت تحویل:</div>
                        <div class="flex-grow">مهر و امضای خریدار:</div>
                    </div>
                    <div class="flex">
                        <div class="flex-grow">
                            <?= $setting['factor_tapimg']!=''?$this->html->image($setting['factor_tapimg'],
                                ['class'=>'footer-img uk-align-center','style'=>'width:150px']):''?>
                        </div>
                        <div class="flex-grow">-</div>
                        <div class="flex-grow">-</div> 
                        <div class="flex-grow"></div>
                    </div>
                    <!-- <h3>text</h3> -->
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- <div class="pagebreak"></div> -->

<div class="page" style="padding-top:30px;">
    <h1 style="text-align: center;">
        صورتحسـاب فـروش كـالا و ارائه خدمت
    </h1>
    <table class="header-table" style="width: 100%">
        <tbody><tr>
            <td style="width: 1.8cm; height: 2.5cm;vertical-align: middle;padding-bottom: 4px;">
                <div class="header-item-wrapper">
                    <div class="portait portrait1">حق‌العمل کار</div>
                </div>
            </td>
            <td style="padding: 0 4px 4px;height: 2cm;">
                <div class="bordered grow header-item-data">
                    <table class="grow centered">
                        <tbody><tr>
                                <td style="width: 7cm">
                                    <span class="label">فروشنده:</span> <?= $setting['store_name']?>
                                </td>
                                <td style="width: 5cm">
                                    <span class="label">شناسه ملی:</span> <?= $setting['sh_meli']?>
                                </td>
                                <td>
                                    <span class="label">شماره ثبت:</span> <?= $setting['sh_sabt']?>
                                </td>
                                <td>
                                    <span class="label">شماره اقتصادی:</span> <?= $setting['sh_eghtesadi']?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="label">نشانی شرکت:</span>
                                    <?= $this->Func->province_list($setting['store_province']).' - '. $setting['store_city'].' - '?>
                                    <?= $setting['store_address']?>
                                </td>
                                <td>
                                    <span class="label">کدپستی:</span> <?= $setting['store_zipcode']?>
                                </td>
                                <td>
                                    <span class="label">تلفن و فکس:</span> 
                                    <div class="sep">
                                        <span><?= $setting['phone'];?></span>
                                        <span><?= $setting['email'];?></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width: 4.5cm;height: 2cm;padding: 0 0 4px;">
                <div class="bordered grow" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div class="font-small">شماره فاکتور:</div>
                        <div class="flex-grow" style="text-align: left"><?= $results['id']?></div>
                    </div>
                    <div class="barcode">
                        <span>#</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 1.8cm; height: 2cm;vertical-align: center; padding: 0 0 4px">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin: 20px">خریدار</div>
                </div>
            </td>
            <td style="height: 2cm;vertical-align: center; padding: 0 4px 4px">
                <?php 
                if( $address != null):?>
                <div class="bordered header-item-data">
                    <table style="height: 100%" class="centered">
                        <tbody>
                            <tr>
                                <td style="width: 6.7cm">
                                    <span class="label">خریدار:</span> <?= $address['first_name'] .' ' . $address['last_name']?>
                                </td>
                                <td style="width: 6.7cm">
                                    <span class="label">شماره‌اقتصادی / شماره‌ملی:</span> <?= $address['nationalid']?>
                                </td>
                                <td>
                                    <span class="label">شناسه ملی:</span> <?= $address['nationalid']?>
                                </td>
                                <td>
                                    <span class="label">شماره ثبت:</span> -
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <span class="label">نشانی:</span> <?= 
                                    $this->Func->province_list($address_u['billing_state']) .' - '.
                                    $pp->getlist($address_u['billing_state'],$address_u['billing_city']) .' - '.
                                    $address_u['billing_address']?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="label">شماره تماس: </span> <?= $address['phone'] . ' / '.$address['emails']?>
                                </td>
                                <td colspan="2">
                                    <span class="label">کد پستی:</span> <?= $address_u['billing_zip']?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif?>
            </td>
            <td style="padding: 0 0 4px">
                <div class="grow bordered" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div>تاریخ:</div>
                        <div class="flex-grow" style="text-align: left">
                            <?= isset($results['created'])?$this->Func->mil_to_shm($results['created']->format('Y-m-d')):''?>
                        </div>
                    </div>
                    <div class="flex">
                        <div>پیگیری:</div>
                        <div class="flex-grow font-medium" style="text-align: left"><?= $results['trackcode']?></div>
                    </div>
                    <div class="barcode">
                        <span>#</span>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
    
    <table class="content-table">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>شناسه کالا یا خدمت</th>
                <th style="width: 30%">شرح کالا یا خدمت</th>
                <th>تعداد</th>
                <th style="width: 2.3cm">مبلغ واحد (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">مبلغ کل (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">تخفیف (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm">مبلغ کل پس از تخفیف (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.3cm"> جمع مالیات و عوارض ارزش افزوده (<?=ShopHelper::CurrencyShow()?>)</th>
                <th style="width: 2.5cm"> جمع کل پس از تخفیف و مالیات و عوارض (<?=ShopHelper::CurrencyShow()?>)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $i=1;
            if(isset($results['shop_ordershippings'])):
            $shipping_list = CartHelper::ShippingList('list');

            foreach($results['shop_ordershippings'] as $item):?>
            <tr>
                <td><?=$i++?></td>
                <td><?= $item['post_id']?></td>
                <td style="text-align: right;">
                    خدمات بسته‌بندی، بیمه حمل و ارسال
                    <?= isset($shipping_list[$item['types']])?'('.$shipping_list[$item['types']].')':'-'?>
                </td>
                <td><span class="ltr">1</span></td>
                <td><span class="ltr"><?= number_format(intval($item['price']))?></span></td>
                <td><span class="ltr"><?= number_format(intval($item['price']))?></span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
                <td><span class="ltr">-</span></td>
            </tr>
            <?php 
            $total+=$item['price'];
            endforeach;endif;?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                </td><td colspan="3" class="font-small">
                    جمع کل پس از تخفیف و کسر مالیات و عوارض (<?=ShopHelper::CurrencyShow()?>):
                </td>
                <td><span class="ltr"><?= number_format(intval($total)); //ShopHelper::PriceShow($total )?></span></td>
            </tr>
            <tr style="background: #fff">
                <td colspan="10" style="height: 2.5cm;vertical-align: top">
                    <div class="flex">
                        <div class="flex-grow">مهر و امضای فروشنده:</div>
                        <div class="flex-grow">تاریخ تحویل:</div>
                        <div class="flex-grow">ساعت تحویل:</div>
                        <div class="flex-grow">مهر و امضای خریدار:</div>
                    </div>
                    <div class="flex">
                        <div class="flex-grow">
                            <?= $setting['factor_tapimg']!=''?$this->html->image($setting['factor_tapimg'],
                                ['class'=>'footer-img uk-align-center','style'=>'width:150px']):''?>
                        </div>
                        <div class="flex-grow">-</div>
                        <div class="flex-grow">-</div> 
                        <div class="flex-grow"></div>
                    </div>
                    <!-- <h3>text</h3> -->
                </td>
            </tr>
        </tfoot>
    </table>
</div> 


<style>
@media print {
.pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
html, body {
    padding: 0;
    margin: 0 auto;
    max-width: 29.7cm;
    -webkit-print-color-adjust: exact;
}
body {
    padding: 0.5cm
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}

table {
    width: 100%;
    table-layout: fixed;
    border-spacing: 0;
}

.header-table {
    table-layout: fixed;
    border-spacing: 0;
}

.header-table td {
    padding: 0;
    vertical-align: top;
}

body {
    font: 9pt IRANYekanWeb;
    direction: rtl;
}

.print-button {
    cursor: pointer;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-radius: 5px;
    background: none;
    -webkit-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
    position: relative;

    outline: none;
    text-align: center;

    padding: 8px 16px;
    font-size: 12px;
    font-size: .857rem;
    line-height: 1.833;
    font-weight: 700;
    background-color: #0fabc6;
    color: #fff;
    border: 1px solid #0fabc6;
}

.page {
    background: white;
    page-break-after: always;
}

.flex {
    display: flex;
}

.flex > * {
    float: left;
}

.flex-grow {
    flex-grow: 10000000;
}

.barcode {
    text-align: center;
    margin: 12px 0 0 0;
    height: 30px;
}

.barcode span {
    font-size: 35pt;
    display: none;
}

.portait {
    transform: rotate(-90deg) translate(0, 40%);
    text-align: center;
}
.portrait1{
    margin:0;
    font-size: 15px;
    padding: 0;
    font-weight: bold;
}
.header-item-wrapper {
    border: 1px solid #000;
    width: 100%;
    height: 100%;
    background: #eee;
    display: flex;
    align-content: center;
}

thead, tfoot {
    background: #eee;
}

.header-item-data {
    height: 100%;
    width: 100%;
}

.bordered {
    border: 1px solid #000;
    padding: 0.12cm;
}

.header-table table {
    width: 100%;
    vertical-align: middle;
}

.content-table {
    border-collapse: collapse;
}

.content-table td, th {
    border: 1px solid #000;
    text-align: center;
    padding: 0.1cm;
    font-weight: normal;
}

table.centered td {
    vertical-align: middle;
}

.serials {
    direction: ltr;
    text-align: left;
}

.title {
    text-align: right;
}

.grow {
    width: 100%;
    height: 100%;
}

.font-small {
    font-size: 8pt;
}

.font-medium {
    font-size: 10pt;
}

.font-big {
    font-size: 15pt;
}

.label {
    font-weight: bold;
    padding: 0 0 0 2px;
}

@page {
    size: A4 landscape;
    margin: 0;
    margin-bottom: 0.5cm;
    margin-top: 0.5cm;
}
.ltr {
    direction: ltr;
    display: block;
}
.sep{
    display: initial;
}
.sep span{
    margin-left:10px;
}
</style>
<script nonce="<?=get_nonce?>">
    var printButton = document.getElementById('print-button');
    printButton.addEventListener('click', function() {
        window.print();
    })
</script>
</body></html>