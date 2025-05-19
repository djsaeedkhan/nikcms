<?php
use Cake\I18n\Time;
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\ShopHelper;?>
<?php $this->assign('shop_title','لیست سفارش های نمایندگی')?>

<div class="table-responsive"><table class="table table-striped table-bordere1d table-hover" style="font-size:12px;">
    <thead>
        <tr>
            <th>#</th>
            <th>شماره سفارش</th>
            <th>محصول</th>
            <th>تعداد</th>
            <th>وضعیت تحویل</th>
            <th>مشخصات مشتری</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
    <?php 
    $total = 0;
    foreach ($logestics['shop_logestic']['shop_orderlogestics'] as $order):
        $items = $order['shop_order']['shop_orderproducts'];
        $user = isset($order['shop_order']['user'])?$order['shop_order']['user']:false;
        foreach ($items as $key => $item):
        ?>
        <tr id="row_<?= $item['product_id'];?>">
            <td>
                <?= $item['id'];?>
            </td>
            <td>
                <?= $order['shop_order']['trackcode'];?>
            </td>
            <td>
                <?= $item['name']?>
                <?php 
                if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                    foreach($item['shop_orderattributes'] as $itm)
                        echo '<div class="small">'.
                            (isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                            (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-').'</div>';
                }?>
            </td>
            <td>
                <?= $item['quantity']; ?>
            </td>
            <td>
                <?= $order['enable'] == "-1"?'-':(
                    $order['enable'] == "1"?
                        '<span class="text-success">تحویل شده</span>':
                        '<span class="text-danger">تحویل نشده</span>'); ?>
            </td>

            <td>
                <?= isset($user['username'])?
                    $user['username'].($user['family'] != ""?' ('.$user['family'].')':''):
                    'نامشخص'?>
            </td>
            <td>
                <?= $this->html->link('مشاهده جزئیات',
                    '/shop/profile/logestic/'.$logestics['shop_logestic_id'].'/detail/'.$item['shop_order_id'],
                    ['class'=>'btn btn-sm btn-outline-secondary','style'=>'font-size:12px;',]); ?></td>
            </tr>
            </td>
        </tr>
    <?php endforeach;endforeach; ?>
    </tbody>
</table></div>