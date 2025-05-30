<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                   مدیریت کاربران نمایندگی ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link('ثبت جدید',
                            ['action'=>'add', $id],
                            ['class'=>'btn btn-sm btn-primary']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordere1d table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id','ردیف') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('shop_logestic_id','عنوان نمایندگی') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('user_id','مشخصات کاربر') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
                    <th scope="col" class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shopLogesticusers as $shopLogesticuser): ?>
                <tr>
                    <td><?= $this->Number->format($shopLogesticuser->id) ?></td>
                    <td><?= $shopLogesticuser->has('shop_logestic') ? 
                        $this->Html->link(
                            $shopLogesticuser->shop_logestic->title, 
                            '/admin/shop/logestics/add/'.$shopLogesticuser->shop_logestic->id
                            ) : '' ?></td>
                    <td><?= $shopLogesticuser->has('user') ? 
                        $this->Html->link($shopLogesticuser->user->username, 
                        '/admin/users/view/'.$shopLogesticuser->user->id) : '' ?></td>
                    <td><?= $this->Func->date2($shopLogesticuser->created) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('حذف دسترسی'), ['action' => 'delete', $shopLogesticuser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopLogesticuser->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
