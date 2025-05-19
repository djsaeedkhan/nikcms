<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    لیست سفارش ها
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
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id','رد') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_order_id','شماره سفارش') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_orderproduct_id','عنوان محصول') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_logestic_id','نمایندگی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id','مشتری') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enable','وضعیت') ?></th>
                <th scope="col"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopOrderlogestics as $shopOrderlogestic): ?>
            <tr>
                <td><?= $this->Number->format($shopOrderlogestic->id) ?></td>
                <td><?= $shopOrderlogestic->has('shop_order') ? $this->Html->link($shopOrderlogestic->shop_order->id, ['controller' => 'Order', 'action' => 'view', $shopOrderlogestic->shop_order->id]) : '' ?>
            
                    <div class="hidme">
                        <?= $this->Html->link(__('جزئیات'), ['action' => 'view', $shopOrderlogestic->id]) ?>
                        <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shopOrderlogestic->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shopOrderlogestic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopOrderlogestic->id)]) ?> -->
                    </div>
                </td>

                <td><?= $shopOrderlogestic->has('shop_orderproduct') ? $this->Html->link($shopOrderlogestic->shop_orderproduct->name, 
                '/admin/posts/edit/'.$shopOrderlogestic->shop_orderproduct->post_id) : '' ?></td>

                <td><?= $shopOrderlogestic->has('shop_logestic') ? $this->Html->link($shopOrderlogestic->shop_logestic->title, ['controller' => 'Logestics', 'action' => 'add', $shopOrderlogestic->shop_logestic->id]) : '' ?></td>

                <td><?= $shopOrderlogestic->has('user') ? $this->Html->link($shopOrderlogestic->user->username .' ('.$shopOrderlogestic->user->family.')', ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $shopOrderlogestic->user->id]) : '' ?></td>

                <td><?= $shopOrderlogestic->enable == 1?'تحویل شده':'تحویل نشده'.'<br>'.h($shopOrderlogestic->enable_descr) ?></td>
                <td><?= $this->Func->date2($shopOrderlogestic->created) ?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table></div>
</div></div>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>