<?php
use Admin\View\Helper\FuncHelper;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
$pp = new Shop\ProvinceCity();
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>پرینت مرسوله فروش</title>
</head>
<body onload1="window.print()" style="width: 100%">
<!-- <button class="print-button" id="print-button">پرینت</button> -->
<?php foreach($resultss as $results):?>
<div class="page" style="width: 100%;padding:0 30px">
    <br>
    <table class="header-table table-bordered" style="width: 100%">
        <tbody>
            <tr>
                <td colspan="3">
                    <b style="font-size:18px"><?= $setting['store_name']?></b>
                    <br><br>
                    نشانی : <?= $setting['store_city'].' - '.$setting['store_address'];?>
                    شماره تماس : <?= $setting['phone']?>
                </td>
                <td colspan="1"><?= $setting['factor_logo'] != ''? 
                    $this->html->image($setting['factor_logo'],
                    ['style'=>'max-height:50px;max-width:100%']):'';?></td>
            </tr>
            <tr>
                <td colspan="3" style="border-left: 0">
                <?php
                $address_u = isset($results['shop_address']['shop_useraddress'])?$results['shop_address']['shop_useraddress']:null;
                $address   = isset($results['shop_address'])?$results['shop_address']:null;
                if( $address != null):?>

                    گیرنده: <b><?= $address['first_name'] .' ' . $address['last_name']?></b>
                    <br><br>
                    آدرس: 
                    <b><?php
                    if(isset($address_u['billing_state'])){
                        echo $this->Func->province_list($address_u['billing_state']);
                        echo ' - ';
                        echo $pp->getlist($address_u['billing_state'],$address_u['billing_city']);
                        echo ' - ';
                        echo isset($address_u['billing_address'])?$address_u['billing_address']:'-';
                    }?></b>&nbsp;&nbsp;
                    <!-- <br><br> -->
                    کد پستی: <b><?= isset($address_u['billing_zip'])?$address_u['billing_zip']:'-';?></b>

                <?php endif?>
                </td>
                <td colspan="1" style="border-right: 0">
                    شماره تماس:<Br>
                    <b><?= isset($address['phone'])?$address['phone']:'-' ?></b>
                </td>
            </tr>

            <tr class="text-center">
                <td>نام کالا</td>
                <td>رنگ / سایز</td>
                <td>شناسه کالا</td>
                <td>تعداد</td>
            </tr>
            
            <?php
            $total = 0;
            $i=1;
            if(isset($results['shop_orderproducts'])):
            foreach($results['shop_orderproducts'] as $item):?>
            <tr class="text-center">
                <td style="text-align:right;">
                    <?= $item['name']?>
                </td>
                <td>
                    <?php if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                        foreach($item['shop_orderattributes'] as $itm)
                            echo '<div class="small">'.
                                //(isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                                (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-').'</div>';
                    }?>
                </td>
                <td><?php 
                if(isset($item['post']['shop_product_metas'])){
                    foreach($item['post']['shop_product_metas'] as $kmt =>$vmt){
                        if($vmt['meta_key'] == 'sku')
                            echo $vmt['meta_value'];
                    }
                }?>
                </td>
                <td><?= $item['quantity']?></td>
            </tr>
            <?php 
            $total+=$item['subtotal'];
            endforeach;endif;?>
            <tr>
                <td colspan="2">شناسه مرسوله: <?= $results['shipmentcode']?></td>
                <td colspan="2">کد سفارش: <?= $results['trackcode']?></td>
            </tr>
        </tbody>
    </table>
</div><br>

<div class="pagebreak"></div>
<?php endforeach;?>


<style>
/* @page { size: A5 landscape } */
.pagebreak { 
    page-break-before: always;
    page-break-after  : always;
}
@media print {
    .pagebreak { 
        page-break-before: always;
        page-break-after  : always;
    } /* page-break-after works, as well */
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
    font: 13px tahoma;
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
    /* page-break-after: always; */
}
.text-center{
    text-align:center !important;
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
    /* size: A5 portrait; */
    margin: 0;
    margin-bottom: 0.5cm;
    margin-top: 0.5cm;
}
.ltr {
    direction: ltr;
    display: block;
}
.table th, .table td {
    padding: 0.72rem 2rem;
    vertical-align: middle;
}
.table-bordered th, .table-bordered td {
    border: 1px solid #333;
    padding: 10px;
}
</style>
</body></html>