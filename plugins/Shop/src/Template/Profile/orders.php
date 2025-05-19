<?php use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;
$this->assign('shop_title','سفارش های من')
?>
<div class="table-responsive"><table class="table table-striped table-bordere1d table-hover" style="font-size:13px;">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('#') ?></th>
            <th scope="col"><?= $this->Paginator->sort('کدپیگیری') ?></th>
            <th scope="col"><?= $this->Paginator->sort('وضعیت') ?></th>
            
            <!-- <th scope="col"><?= $this->Paginator->sort('تعداد محصول') ?></th> -->
            <th scope="col"><?= $this->Paginator->sort('مجموع مبلغ سفارش') ?></th>
            <th scope="col"><?= $this->Paginator->sort('تاریخ سفارش') ?></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach ($results as $result): ?>
        <tr>
            <td><?= ++$i;?></td>
            <td>
                <?= $this->html->link(h($result->trackcode),
                    ['/orders','?'=>['id'=>$result->id] ],
                    ['title'=>'نمایش جزئیات سفارش'])?>
            </td>
            <td>
                <?= CartHelper::Predata('order_status',$result->status);?>
                <?= ($result->enable==0)?'<span class="badge badge-danger">پایان یافته</span>':'' ?>
            </td>
            
            <!-- <td><?php // (isset($result->shop_orderproducts)?count($result->shop_orderproducts):'0') ?></td> -->
            <td><?php /* $temp = 0;if(isset($result->shop_orderproducts)){
                foreach($result->shop_orderproducts as $p){
                    $temp += intval($p['subtotal']);
                }} */?>
                <?= ShopHelper::PriceShow(CartHelper::OrderTotalPrice($result->trackcode));?>
            </td>
            <td><?= $this->Func->date2($result->created);?></td>
            <td>
            <?php
            echo $this->html->link('جزئیات سفارش',
                '/product/payment/'.$result->trackcode,[
                    'class'=>'btn btn-sm btn-secondary',
                    'style'=>'font-size:12px;',
                    ]).'&nbsp;';

            if(isset($result->shop_orderrefunds) and count($result->shop_orderrefunds)){
                foreach($result->shop_orderrefunds as $tmp){
                    echo 'وضعیت مرجوعی:<br><b>'. CartHelper::Predata('order_refundtype',$tmp->status).'</b>';
                }
            }
            elseif(in_array($result->status,['paid','processing','completed'])){
                echo $this->html->link('ثبت مرجوعی',
                    '/shop/addrefund/'.$result->trackcode,[
                        'style'=>'font-size:12px;',
                        'class'=>'btn btn-sm btn-danger',
                        'title'=>'مرجوعی سفارش']);
            }

            ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table></div>