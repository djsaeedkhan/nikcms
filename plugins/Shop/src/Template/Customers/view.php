<?php

use Shop\View\Helper\CartHelper;

$pp = new Shop\ProvinceCity();?>

<div class="card cart1"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row" style="width: 200px;"><?= __('نام و نام خانوادگی') ?></th>
            <td><?= $result->has('user') ? $result->user->username .' ('.$result->user->family.')': '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('آدرس ایمیل') ?></th>
            <td><?= h($result->emails) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('آدرس پستی') ?></th>
            <td>
                <?= $this->Func->province_list($result->billing_state)?>  
                <?=$pp->getlist($result->billing_state,$result->billing_city);?>
            </td>
        </tr>
    </table>
    </div>
</div></div>
    


<div class="card cart1 d-none"><div class="card-body">
        <h4><?= __('لیست آدرس ها');?></h4><br>
        <?php if (!empty($useaddr)): ?>
        <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
            <tr>
                <th scope="col"><?= __('استان') ?> / <?= __('شهرستان') ?></th>
                <th scope="col"><?= __('ادرس') ?></th>
                <th scope="col"><?= __('کدپستی') ?></th>
                <th scope="col"><?= __('نقشه 1') ?></th>
                <th scope="col"><?= __('نقشه 2') ?></th>
                <!-- <th scope="col" class="actions"><?= __('Actions') ?></th> -->
            </tr>
            <?php foreach ($useaddr as $shopOrders): ?>
            <tr>
                <td>
                    <?= $this->Func->province_list($shopOrders->billing_state) ?> » 
                    <?= h($shopOrders->billing_city) ?>
                </td>
                <td><?= h($shopOrders->billing_address) ?></td>
                <td><?= h($shopOrders->billing_zip	) ?></td>
                <td><?= h($shopOrders->m1) ?></td>
                <td><?= h($shopOrders->m2) ?></td>
                <!-- <td class="actions">
                    <?php // $this->Html->link(__('View'), ['controller' => 'ShopOrders', 'action' => 'view', $shopOrders->id]) ?>
                    <?php // $this->Html->link(__('Edit'), ['controller' => 'ShopOrders', 'action' => 'edit', $shopOrders->id]) ?>
                    <?php // $this->Form->postlink(__('Delete'), ['controller' => 'ShopOrders', 'action' => 'delete', $shopOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrders->id)]) ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="card cart1"><div class="card-body">
        <h4><?= __('لیست سفارش ها') ?></h4>
        <?php if (isset($result->user->shop_orders)): ?>
        <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
            <tr>
                <th scope="col"><?= __('کد سفارش') ?></th>
                <th scope="col"><?= __('واحد پولی') ?></th>
                <th scope="col"><?= __('وضعیت') ?></th>
                <th scope="col"><?= __('وضعیت سفارش') ?></th>
                <!-- <th scope="col"><?= __('Shop Address Id') ?></th> -->
                <th scope="col"><?= __('تاریخ سفارش') ?></th>
            </tr>
            <?php foreach ($result->user->shop_orders as $shopOrders): ?>
            <tr>
                <td><?= $this->html->link($shopOrders->trackcode,
                    '/product/payment/'.$shopOrders->trackcode,['target'=>'_blank']) ?></td>
                <td><?= h($shopOrders->currency) ?></td>
                <td><?= h($shopOrders->enable) ?></td>
                <td><?= CartHelper::Predata('order_status',$shopOrders->status) ?></td>
                <!-- <td><?= h($shopOrders->shop_address_id) ?></td> -->
                <td><?= $this->Func->date2($shopOrders->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>
