<?php 
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\PaymentHelper;
use Shop\View\Helper\ShopHelper;
$pp = new Shop\ProvinceCity();?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-sm-9 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h3 class="content-header-title1 float-right mb-0">
                    سفارش: <?=$result['trackcode']?>
                    <?php if($result['token'] == 1):?>
                        <span title="صحت سنجی پیامکی انجام شده است">
                            <i data-feather="check" class="bg-success" style="border: 1px solid #28C76F;border-radius: 50px;color: #FFF;"></i>
                        </span>
                    <?php elseif($result['token'] != ''): 
                        echo " | کد صحت سنجی: " .$result['token'];
                    endif;?>
                </h3>
            </div>
        </div>
    </div>

    <div class="content-header-right text-md-left col-md-3 col-sm-3">

        <div class="dropdown chart-dropdown" style="display: initial;">
            <span class="badge badge-dark badge-sm font-medium ml-1 cursor-pointer" data-toggle="dropdown" style="vertical-align: middle;">
                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" style="vertical-align: inherit;"></i> بیشتر
            </span>
            <div class="dropdown-menu dropdown-menu-right">
                <?= $this->html->link('<i data-feather="refresh-cw"></i> تغییر وضعیت',
                    ['action'=>'status',$result['id']],
                    ['class'=>'dropdown-item','escape'=>false ]);?>

                <?= $this->html->link('<i data-feather="edit"></i> ویرایش سفارش ',
                    ['action'=>'status',$result['id']],
                    ['class'=>'dropdown-item','escape'=>false ]);?>
                    
                <?= $this->html->link('<i data-feather="printer"></i> پرینت فاکتور',
                    ['controller'=>'Manage','action'=>'payment',$result['trackcode'],'pdf'],
                    ['class'=>'dropdown-item','target'=>'_blank','escape'=>false ]);?>

                <?= $this->html->link('<i data-feather="printer"></i> پرینت مرسوله',
                    [$result['id'],'?'=>['print'=>'box'] ],
                    ['class'=>'dropdown-item','escape'=>false,'target'=>'_blank', ]);?>
            </div>
        </div>

        <?= $this->Form->postlink('حذف',
            ['action'=>'delete',$result['id']],
            ['class'=>'btn btn-sm btn-danger float-left',
                'confirm'=>'برای حذف این سفارش مطمئن هستید؟',
                'target'=>'_parent']);?>
    </div>
</div>

<div class="card cart1"><div class="card-body1">
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-right bg-white">
            <thead>
            <tr>
                <th>کد سفارش</th>
                <th>شناسه مرسوله</th>
                <th>مشخصات کاربری</th>
                <th>واحد پول</th>
                <th>وضعیت سفارش</th>
            </tr>
            </thead>
        <tbody>
            <tr>
                <td><?= $result['trackcode']?></td>
                <td><?= $result['shipmentcode']?></td>
                <td><?= isset($result['user'])?
                    $this->html->link($result['user']['family'] .' ('.$result['user']['username'].')',
                    '/admin/users/view/'.$result['user_id'],['target'=>'_blank'])
                    :'نامشخص'?></td>
                <td><?= CartHelper::Predata('currency',$result['currency'])?></td>
                <td><?= CartHelper::Predata('order_status',$result['status'])?></td>
            </tr>
        </tbody>
        </table>
    </div>
</div></div>
<!-- --------------------------------------------------- --->
<!-- --------------------------------------------------- --->
<h2 class="text-right mb-2">
    فاکتور
</h2>
<div class="card cart1"><div class="card-body1">
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-right bg-white">
            <thead>
            <tr>
                <th>#</th>
                <th>عنوان محصول</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>مبلغ کل</th>
            </tr>
            </thead>
        <tbody>

        <?php $i=1;$total = 0;
            foreach ($result['shop_orderproducts'] as $key => $item):
            ?>
            <tr id="row_<?= $item['product_id'];?>">
                <td>
                    <?= $i++?>
                </td>
                <td>
                    <strong><?= $item['name']?></strong>
                    <?php 
                    if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                        foreach($item['shop_orderattributes'] as $itm)
                            echo '<div class="small">'.
                                (isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                                (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-').'</div>';
                    }?>
                </td>
                <td>
                    <?= ShopHelper::PriceShow($item['price']);?>
                </td>
                <td>
                    <?= $item['quantity']; ?>
                </td>
                <td id="subtotal-<?=$key; ?>">
                    <?= ShopHelper::PriceShow($item['subtotal']);$total+=$item['subtotal'];?>
                </td>
            </tr>
            <?php endforeach; 
            
            $shipping_list = CartHelper::ShippingList('list');
            foreach ($result['shop_ordershippings'] as $key => $item):?>
                <tr>
                    <td>
                        <?= $i++?>
                    </td>
                    <td>
                        <strong>هزینه ارسال : <?= isset($shipping_list[$item['types']])?$shipping_list[$item['types']]:'نامشخص'?></strong>
                    </td>
                    <td>
                        <?= ShopHelper::PriceShow($item['price']);?>
                    </td>
                    <td>
                        1
                    </td>
                    <td id="subtotal-<?=$key; ?>">
                        <?= ShopHelper::PriceShow($item['price']);$total+=$item['price'];?>
                    </td>
                </tr>
                <?php endforeach; ?>

            <tr>
                <td colspan="4" style="text-align:left">
                    جمع کل فاکتور: 
                </td>
                <td colspan="2">
                    <span class="nor1mal" id="subtotal">
                        <span class="badge badge-success"><?= ShopHelper::PriceShow($total);?></span>
                    </span>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
</div></div>
<!-- --------------------------------------------------- --->
<!-- --------------------------------------------------- --->
<h2 class="text-right mb-2">وضعیت پرداخت</h2>
<div class="card cart1"><div class="card-body1">
    <div>
        <?php
        $paid = false;
        if(isset($result['shop_payments'])):?>
            <table class="table table-striped table-bordered text-right bg-white">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>کد پیگیری</th>
                        <th>درگاه پرداخت</th>
                        <th>مبلغ پرداخت</th>
                        <th>وضعیت پرداخت</th>
                        <th>تاریخ پرداخت</th>
                    </tr>
                </thead>
                <tbody>
            <?php $i = 1; 
            foreach($result['shop_payments'] as $pm):?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?= $pm->myrahid?></td>
                    <td><?= CartHelper::Predata('terminal_list',$pm->terminalid)?></td>
                    <td><?= ShopHelper::PriceShow($pm->price)?></td>
                    <td>
                        <span class="badge <?= ($pm->paid ==1?'badge-success':'badge-secondary');?> ">
                            <?= CartHelper::Predata('pay_status',$pm->paid)?>
                        </span>
                    </td>
                    <td><?= $this->Func->date2($pm->created)?></td>
                </tr>

                <?php if($pm['status'] == 1){$paid = true;}
            endforeach;?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div></div>
<!-- --------------------------------------------------- --->
<!-- --------------------------------------------------- --->
<h2 class="text-right mb-2">
    مشخصات ارسال
</h2>
<div class="card cart1"><div class="card-body1">
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-right bg-white">
            <thead>
            <tr>
                <th>روش ارسال</th>
                <th>هزینه ارسال</th>
                <th>زمانبندی ارسال</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach ($result['shop_ordershippings'] as $item):?>
            <tr>
                <td><strong><?= isset($shipping_list[$item['types']])?$shipping_list[$item['types']]:'نامشخص'?></strong></td>
                <td><?= ShopHelper::PriceShow($item['price']);?></td>
                <td><?= $item['sendtime']; ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
        </table>
    </div>
</div></div>
<!-- --------------------------------------------------- --->
<!-- --------------------------------------------------- --->
<h2 class="text-right mb-2">
     آدرس
</h2>
<?php if(isset($result['shop_address'])): $item = $result['shop_address']?>
    <div class="card cart1">
    <table class="table table-striped table-bordered text-right bg-white">
        <thead>
        <tr>
            <th>کدملی</th>
            <th>نام و نام خانوادگی</th>
            <th>ادرس ایمیل</th>
            <th>شماره تلفن</th>
        </tr>
        </thead>
    <tbody>
        <tr>
            <td><?= $item['nationalid']!= ''?$item['nationalid']:'-';?></td>
            <td><?= $item['first_name']?> | <?= $item['last_name']?></td>
            <td><?= $item['emails']!=''?$item['emails']:'-'?></td>
            <td><?= $item['phone']!= ''?$item['phone']:'-';?></td>
        </tr>
    </tbody>
    </table></div>
    
    <?php if(isset($item['shop_useraddress'])): $item = $item['shop_useraddress']?>
    <div class="card cart1">
    <table class="table table-striped table-bordered text-right bg-white">
        <thead>
        <tr>
            <th>استان / شهرستان</th>
            <th>آدرس پستی</th>
            <th>کدپستی</th>
        </tr>
        </thead>
    <tbody>
        <tr>
            <td><?= $this->Func->province_list($item['billing_state'])?> | 
                <?=$pp->getlist($item['billing_state'],$item['billing_city']);?>
            </td>
            <td><?= $item['billing_address']!=''?$item['billing_address']:'-'?></td>
            <td><?= $item['billing_zip']!= ''?$item['billing_zip']:'-';?></td>
        </tr>
    </tbody>
    </table>
    </div>
    <?php endif;?>

<?php endif;?>
<!-- --------------------------------------------------- --->
<!-- --------------------------------------------------- --->
<h2 class="text-right mb-2">
    لاگ سفارش
</h2>
<?php if(isset($result['shop_orderlogs'])): $item = $result['shop_orderlogs']?>
    <div class="card cart1">
    <table class="table table-striped table-bordered text-right bg-white">
        <thead>
        <tr>
            <th>کاربر اقدام کننده</th>
            <th>توضیحات</th>
            <th>تاریخ</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach (array_reverse($result['shop_orderlogs']) as $item):?>
            <tr>
                <td><?= isset($item['user']['username'])?$item['user']['username']:'-'?></td>
                <td><?= $item['status']?></td>
                <td><?= $this->Func->date2($item['created']) ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </div>
<?php endif;?>
<style>
.table th,.table td{
    padding-right: 5px;
    padding-left: 5px;
    text-align: center;
    letter-spacing: -0.5px;
}


</style>