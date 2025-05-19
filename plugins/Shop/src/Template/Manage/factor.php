<?php
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;?>

<section id="content" dir="rtl" class="text-right">
    <div class="content-wrap pt-4 pb-1" style="overflow: visible;">
        <div class="container">
            <?php $progress = 'send';include_once('progress.php')?>
        </div>
		<div class="container">
            <h4 class="text-right mb-2">پیش فاکتور</h4>
            <table class="table table-bordered text-right bg-white">
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
                    <!-- ----------------------------------------------- -->
                    <!-- ----------------------------------------------- -->
                    <?php 
                    $tabindex = 1;
                    $i=1;
                    $total_price = 0;
                    foreach (array_reverse($shop['Orderproducts']) as $key => $item):
                    $total_price += $item['subtotal'];
                    $result = [];
                    if(isset($item['product_id']) and $item['product_id'] != ''){
                        $result = $this->Query->post(null,[
                            'id' => $item['product_id'],
                            'get_type'=>'first']);

                        /* $product = TableRegistry::getTableLocator()->get('Shop.Posts')
                            ->get($item['product_id'],['contain'=>['ShopProductMetas']]); */
                    }?>
                    <tr id="row_<?= $item['product_id'];?>" >
                        <td>
                            <?= $i++?>
                        </td>
                        <td>
                            <strong><a href="<?= $this->Query->the_permalink(['id'=>$item['product_id'] ]); ?>">
                                <?= $result['title']?>
                            </a></strong>
                            <?php 
                            if(isset($item['attrlist']) and count($item['attrlist'])){
                                foreach($item['attrlist'] as $kitm => $itm){
                                    echo $itm != ''?'<div class="small">'.$kitm.' : '.$itm.'</div>' : '';
                                }
                            }?>

                            <?php
                            /* if($paid == true):
                                $p = $this->Func->MetaList($product);
                                if(isset($p['logesticlists']) and $p['logesticlists'] != ""):
                                    echo $this->html->link(
                                        (isset($item['shop_orderlogestics'][0])?'مشاهده وضعیت نمایندگی':'انتخاب نمایندگی'),
                                        '/product/factor/logestic/'.$item['id'],
                                        ['class'=>'btn btn-secondary btn-sm','style'=>'font-size:12px;']);
                                endif;
                            endif; */?>
                        </td>
                        <td>
                            <?= ShopHelper::PriceShow($item['price']);?>
                        </td>
                        <td>
                            <?= $item['quantity'] ?>
                        </td>
                        <td id="subtotal-<?=$key; ?>">
                            <?= ShopHelper::PriceShow($item['subtotal']);?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- ----------------------------------------------- -->
                    <!-- ----------------------------------------------- -->
                    <tr>
                        <td colspan="1"><?= $i++?></td>
                        <td colspan="3"> هزینه ارسال 
                            <b><?=isset($shipping['title'])?$shipping['title'] : '-'?></b>
                        </td>
                        <td>
                            <?=isset($shipping['price'])?ShopHelper::PriceShow($shipping['price']) : '-';
                                $total_price += $shipping['price'];?>
                        </td>
                    </tr>
                    <!-- ----------------------------------------------- -->
                    <!-- ----------------------------------------------- -->
                    <tr>
                        <td colspan="4" style="text-align:left">
                            جمع کل فاکتور: 
                        </td>
                        <td colspan="2">
                            <span class="nor1mal" id="subtotal">
                                <?= ShopHelper::PriceShow($total_price);?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table><BR>
            <!-- ----------------------------------------------------------- -->
            <!-- ----------------------------------------------------------- -->
            <?= $this->Form->create(null);?>
            <div class="row">
                <div class="col-sm-6 rtl text-right">
                    <h4 class="text-right mb-2">توضیحات سفارش</h4>
                    <?= $this->Form->control('billing_desc', [
                        'rows'=>'5','type'=>'textarea','label'=>false,'class' => 'form-control']); ?>
                </div>
                
            </div><br><br>
            
            <!-- ----------------------------------------------------------- -->            
            <h4 class="text-right mb-2">
                زمان بندی تحویل
            </h4><br>
            <?php
            $time = new Time('now');
            for($i=1; $i<6;$i++){
                $date = $time->format('Y-m-d');
                $temp = CartHelper::ShippingScheduleCheck($time , $i , $current_useraddress,$shipping);
                $enable = $temp['enable'];
                $label = $temp['label'];
                echo '<div class="alert alert-light useraddress tmpclass1 tmpclass2 '.  ($enable == true?'':'disabled').'" style="'.($enable ==true?'background: rgb(0 255 0 / 10%);':'background: rgb(255 0 0 / 10%);').'">';
                echo $this->form->radio('shipping.sendtime.',
                    [$date => 
                        ($i ==1?'امروز، ':'').
                        jdate('l ',strtotime($time->format('Y-m-d'))).' '.
                        $this->Func->mil_to_shm($date).
                        ($label !='' ?'<br><b>'.$label.'</b>':'').
                        ($enable == true?'<div class="small text-danger pt-1"><br></div>':'<div class="small text-danger text-center pt-1">ظرفیت تکمیل / غیرقابل انتخاب</div>')
                    ],
                    [
                        ($enable ==true?'':'disabled'),'class'=>'text-white',
                        'style'=>'margin-left:10px;text-align:center','required',
                        'oninvalid'=>"this.setCustomValidity('لطفا تاریخ ارسال مورد نظر را انتخاب کنید')",
                        'oninput'=>"this.setCustomValidity('')",
                        'escape'=>false]);
                echo '</div>';
                $time->addDays(1);
            }?>
            <div class="clearfix"></div><br>
            <div style="font-size: 14px;font-weight: normal;">میتوانید به مرحله قبل برگشته و  با تغییر روش ارسال، "زمان بندی تحویل" را تغییر دهید</div>
            <br>
            
            <!-- ----------------------------------------------------------- -->
            <!-- ----------------------------------------------------------- -->
            <!-- ----------------------------------------------------------- -->

            <div class="row">
                <div class="col col-sm-12">
                    <?= $this->html->link('مرحله قبل  <i class="icon-angle-left shp_icn"></i> ', 
                        '/product/cart',
                        ['class' => 'btn btn-default btn-sm float-left','escape'=>false]);?>
    
                    <?= $this->Form->button('<i class="icon-angle-right shp_icn"></i> ثبت سفارش / پرداخت', 
                        ['class' => 'btn btn-success btn-sm float-right', 
                        'escape' => false]); ?>

                    <?= $this->Form->end(); ?>
                </div>
            </div><br><br>

        </div>
    </div>
</section>