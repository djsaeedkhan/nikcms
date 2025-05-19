<?php
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\PaymentHelper;
use Shop\View\Helper\ShopHelper;

$paid = false;
foreach($results['shop_payments'] as $pm):
    if($pm['paid'] == 1)
        $paid = true;
endforeach;

?>
<section id="content">
	<div class="content-wrap pt-4 clearfix">
        <div class="container">
            <?php 
            if($results['status'] == 'pending')
                $progress = 'payment';
            else $progress = 'tracker';
            include_once('progress.php')?>
        </div>
        <div class="container">
            <h2 class="text-right mb-2" style="font-weight: normal;">
                فاکتور : <?=$results['trackcode']?>

                <?= $paid == true?
                    $this->html->link('پرینت فاکتور PDF',
                        [$results['trackcode'],'pdf'],
                        ['class'=>'btn btn-sm btn-info text-white'])

                    :$this->html->link('پرینت فاکتور PDF',
                        "#",
                        ['class'=>'btn btn-sm btn-info text-white','confirm'=>'فاکتور پس از پرداخت قابل دسترس می باشد']);?>
                
                <div style="float: left;">
                    <?php
                    if($results['status'] == 'pending')
                        echo $this->html->link('لغو سفارش',
                            [$results['trackcode'],'delete'],
                            ['class'=>'btn btn-sm btn-danger','confirm'=>'آیا برای لغو این سفارش مطمئن هستید؟']);
                    ?>
                </div>
            </h2>
            <?php if($results['status'] == 'cancelled')
                echo '<div class="alert alert-danger">این سفارش لغو شده است</div>';?>
            <table class="table table-striped1 text-right bg-white">
                <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>تصویر</th> -->
                    <th>عنوان محصول</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>مبلغ کل</th>
                    <th></th>
                </tr>
                </thead>
            <tbody>

            <?php $i=1;$total = 0;
                foreach ($results['shop_orderproducts'] as $key => $item):
                $result = [];
                if(isset($item['product_id']) and $item['product_id'] != ''){
                    $result = $this->Query->post(null,['id' => $item['product_id'],'get_type'=>'first']);
                    
                }?>
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

                    <td id="subtotal-<?=$key; ?>">
                        <?php
                        //if($paid == true):
                            $p = $this->Func->MetaList($item['post']);
                            if(isset($p['logesticlists']) and $p['logesticlists'] != ""):
                                echo $this->html->link(
                                    (isset($item['shop_orderlogestics'][0])?'مشاهده وضعیت نمایندگی':'انتخاب نمایندگی'),
                                    '/product/factor/logestic/'.$item['id'],
                                    ['class'=>'btn btn-secondary btn-sm','style'=>'font-size:12px;']);
                            endif;
                        //endif;?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php 
                foreach ($results['shop_ordershippings'] as $key => $item):
                $ship = CartHelper::ShippingList('id',['id'=> $item['types']]);
                ?>
                <tr>
                    <td>
                        <?= $i++?>
                    </td>
                    <td colspan="3">
                        <strong><?=isset($ship['title'])? $ship['title'] :'-'?></strong>
                    </td>
                    <td id="subtotal-<?=$key; ?>">
                        <?= ShopHelper::PriceShow($item['price']);$total+=$item['price'];?>
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" style="text-align:right">
                    </td>
                    <td colspan="2" style="text-align:left">
                        جمع کل فاکتور: 
                    </td>
                    <td colspan="2">
                        <span class="nor1mal" id="subtotal">
                            <?= ShopHelper::PriceShow($total);?>
                        </span>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="clear clearfix"></div><br>

        <?php if(ShopHelper::Setting('terminal_list') != '' ):?>
		<div class="container">
            <div class="text-right">
                <?php
                if($paid == true){
                    echo '<div class="alert alert-success">این سفارش قبلا پرداخت شده است</div>';
                }
                elseif($results['status'] != 'pending'){
                    echo '<div class="badge badge-warning">امکان پرداخت این سفارش وجود ندارد</div>';
                }
                else{
                    echo $this->Form->create(null,['url'=>[$results['trackcode'],'goto']]);
                    foreach(array(ShopHelper::Setting('terminal_list')) as $temp){
                        $tmp = PaymentHelper::getTerminal($temp);
                        echo '<div class="alert alert-light useraddress tmpclass1">';
                        echo $this->form->radio('payment.terminal.',
                            [$tmp['slug'] => $this->html->image($tmp['image'],
                                ['style'=>'display: block;height:50px;margin-bottom:10px;'])
                            ],
                            ['style'=>'margin-left:10px;text-align:center','required','escape'=>false]);
                        echo '</div>';
                    }
                    echo '<div class="clearfix"></div>';
                    echo $this->Form->button('برو برای پرداخت',['class' => 'btn btn-success btn-sm']);
                    echo $this->Form->end(); 
                }
                ?>
            </div>
            <br><br>

            
            <?php
            $paid = false;
            if(isset($results['shop_payments']) and $results['shop_payments']):?>
                <h4 class="text-right mb-2" style="font-weight: normal;">گزارش پرداخت ها</h4>
                <table class="table table-striped1 text-right bg-white small">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>کد پیگیری</th>
                            <th>درگاه پرداخت</th>
                            <!-- <th>مبلغ پرداخت</th> -->
                            <th>وضعیت پرداخت</th>
                            <th>تاریخ پرداخت</th>
                        </tr>
                        </thead>
                    <tbody>
                <?php $i = 1; 
                foreach($results['shop_payments'] as $pm):?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?= $pm->myrahid?></td>
                        <td><?= CartHelper::Predata('terminal_list',$pm->terminalid)?></td>
                        <!-- <td><?= ShopHelper::PriceShow($pm->price)?></td> -->
                        <td>
                            <span class="badge <?= ($pm->paid ==1?'badge-success':'badge-light');?> ">
                                <?= CartHelper::Predata('pay_status',$pm->paid)?>
                            </span>
                        </td>
                        <td><?= $this->Func->date2($pm->created)?></td>
                    </tr>

                    <?php if($pm['paid'] == 1){$paid = true;}
                endforeach;?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
        <?php endif;?>
    </div>
</section>