<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    جزئیات سفارش نمایندگی #<?= $shopOrderlogestic->id?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-borderless table-hover">
        <tr>
            <th scope="row" width="300"><?= __('شماره سفارش') ?></th>
            <td><?= $shopOrderlogestic->has('shop_order') ? $this->Html->link($shopOrderlogestic->shop_order->id, ['controller' => 'ShopOrders', 'action' => 'view', $shopOrderlogestic->shop_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('نام محصول') ?></th>
            <td><?= $shopOrderlogestic->has('shop_orderproduct') ? $this->Html->link($shopOrderlogestic->shop_orderproduct->name, 
                '/admin/posts/edit/'.$shopOrderlogestic->shop_orderproduct->post_id) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('نام نمایندگی') ?></th>
            <td><?= $shopOrderlogestic->has('shop_logestic') ? $this->Html->link($shopOrderlogestic->shop_logestic->title, ['controller' => 'Logestics', 'action' => 'add', $shopOrderlogestic->shop_logestic->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('مشتری') ?></th>
            <td><?= $shopOrderlogestic->has('user') ? $this->Html->link($shopOrderlogestic->user->username .' ('.$shopOrderlogestic->user->family.')', ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $shopOrderlogestic->user->id]) : '' ?></td>
        </tr>
        <!-- <tr>
            <th scope="row"><?= __('وضعیت فعال') ?></th>
            <td><?= h($shopOrderlogestic->enable_descr) ?></td>
        </tr> -->
        
        <tr>
            <th scope="row"><?= __('وضعیت نمایش') ?></th>
            <td><?= $shopOrderlogestic->enable == 1?'تحویل شده':'تحویل نشده'.'<br>'.h($shopOrderlogestic->enable_descr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('تاریخ ثبت') ?></th>
            <td><?= $this->Func->date2($shopOrderlogestic->created) ?></td>
        </tr>
        </tbody>
    </table></div>
</div></div>

<h4><?= __('لیست وضعیت های ثبت شده') ?></h4>
<?php if (!empty($shopOrderlogestic->shop_orderlogesticlogs)): ?>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-borderless table-hover" style="font-size:13px;">
    <tr>
        <th scope="col">ردیف</th>
        <th scope="col">توضیحات</th>
        <!-- <th scope="col"><?= __('Image') ?></th> -->
        <th width="150" scope="col">اقدام کننده</th>
        <th width="100" scope="col">تاریخ ثبت</th>
    </tr>
    <?php foreach ($shopOrderlogestic->shop_orderlogesticlogs as $shopOrderlogesticlogs): ?>
    <tr>
        <td><?= h($shopOrderlogesticlogs->id) ?></td>
        <td><?= h($shopOrderlogesticlogs->descr) ?>
            <!-- <div class="hidme">
                <?= $this->Html->link(__('View'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'view', $shopOrderlogesticlogs->id]) ?>
                <?= $this->Html->link(__('Edit'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'edit', $shopOrderlogesticlogs->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShopOrderlogesticlogs', 'action' => 'delete', $shopOrderlogesticlogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderlogesticlogs->id)]) ?>
            </div> -->
        </td>
        <!-- <td><?= h($shopOrderlogesticlogs->image) ?></td> -->
        <td><?= h($shopOrderlogesticlogs->user->username).'<br>('.$shopOrderlogesticlogs->user->family.')' ?></td>
        <td><?= $this->Func->date2($shopOrderlogesticlogs->created) ?></td>
    </tr>
    <?php endforeach; ?>
    </table></div>
</div></div>
<?php endif; ?>