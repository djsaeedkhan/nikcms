<?php
use Shop\View\Helper\ShopHelper;
use Shop\View\Helper\CartHelper;
echo $this->element('Shop.report');?>
<div class="table-responsive">
    <table class="table table-striped bg-white table-bordered table-hover1" id="tbexample">
        <thead>
            <tr>
                <th></th>
                <th>زمان سفارش</th>
                <th>شماره سفارش</th>
                <th>شماره مرسوله</th>
                <th>تاریخ تعهد ارسال</th>
                <th>استان</th>
                <th>شهر</th>
                <th>عنوان سفارش</th>
                <th>تعداد</th>
                <th>SKU</th>
                <th>قیمت فروش واحد کالا</th>
                <th>شیوه ارسال</th>
                <th>مبلغ پرداختی</th>
                <th>وضعیت محموله</th>
                <th>تاریخ ارسال کالا</th>
                <th>نام و نام خانوادگی</th>
                <th>آدرس</th>
                <th>شماره موبایل</th>
                <th>شرکت ارسال کننده کالا</th>
                <th>شماره بارنامه</th>
                <th>کد دریافت کالا</th>
                <th>کرایه پرداختی ارسال</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i=1;
            $pp = new Shop\ProvinceCity();
            foreach($results as $res):
                $qty = 0;
                $total_price = 0;
                $shipping_list = CartHelper::ShippingList('list');
                $send_price = 0;
                $send_method = '';
                $sent_time = '';
                $paid = false;
                
                foreach ($res['shop_ordershippings'] as $key => $item):
                    $send_method = isset($shipping_list[$item['types']])?$shipping_list[$item['types']]:'نامشخص';
                    $send_price = $item['price'];
                    $total_price += $item['price'];
                    $sent_time = $item['sendtime'];
                endforeach;

                foreach($res['shop_payments'] as $pm):
                    if($pm['status'] == 1)$paid = true;
                endforeach;
                ?>
            <tr role="row">
                <td><?= $i++?></td>
                <td><?= $this->Func->date2($res->created) ?></td>
                <td><?= h($res->trackcode) ?></td>
                <td><?= h($res->shipmentcode) ?></td>
                <td>
                    <?=$sent_time?>
                </td>
                <td>
                    <?= isset($res['shop_address']['shop_useraddress']['billing_state'])?
                        $this->Func->province_list($res['shop_address']['shop_useraddress']['billing_state']):''?>
                </td>
                <td>
                    <?= isset($res['shop_address']['shop_useraddress']['billing_city'])?
                        $pp->getlist(
                            $res['shop_address']['shop_useraddress']['billing_state'],
                            $res['shop_address']['shop_useraddress']['billing_city']):''?>
                </td>
                <td>
                    <?php foreach ($res['shop_orderproducts'] as $key => $item):?>
                        <?= trim($item['name'])?><?php 
                        if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                            foreach($item['shop_orderattributes'] as $itm)
                                echo trim(
                                    (isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                                    (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-'));
                        }?> / واحد: <?= ShopHelper::PriceShow($item['price']);?> / تعداد: <?= $item['quantity'];$qty += $item['quantity'];?> / کل:<?= ShopHelper::PriceShow($item['subtotal']);$total_price+=$item['subtotal'];?>
                        <br>
                    <?php endforeach;?>
                </td>
                <td><?= $qty?></td>
                <td><!-- SKU --></td>
                <td><!-- قیمت فروش واحد کالا --></td>
                <td>
                    <?= $send_method; ?>
                </td>
                <td>
                    <?= ShopHelper::PriceShow($total_price);?><?= 
                    $paid== true?
                        '[پرداخت شده]':
                        '[پرداخت نشده]'?>
                </td>
                <td><!-- وضعیت محموله --></td>
                <td><!-- تاریخ ارسال کالا--></td>
                <td>
                    <?= isset($res['shop_address']['first_name'])?$res['shop_address']['first_name']:''?>&nbsp;
                    <?= isset($res['shop_address']['last_name'])?$res['shop_address']['last_name']:''?>
                </td>
                <td>
                    <?= isset($res['shop_address']['shop_useraddress']['billing_address'])?$res['shop_address']['shop_useraddress']['billing_address']:''?>
                </td>
                <td>
                    <?= isset($res['shop_address']['phone'])?$res['shop_address']['phone']:''?>
                </td>
                <td><!-- شرکت ارسال کننده کالا--></td>
                <td><!-- شماره بارنامه--></td>
                <td><?= h($res->token) ?></td>
                <td>
                    <?= ShopHelper::PriceShow($send_price)?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>