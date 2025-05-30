<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    لیست نمایندگی ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link('ثبت جدید',
                            ['action'=>'add'],['class'=>'btn btn-sm btn-primary']);?>

                        <?= $this->Auths->link('مدیریت دسته بندی',
                            ['controller'=>'Logesticlists'],['class'=>'btn btn-sm btn-primary mx-1']);?>
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
                <!-- <th scope="col"><?= $this->Paginator->sort('id','رد') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('image','تصویر') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','عنوان') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descr','توضیحات') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address','آدرس') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shop_logesticlist_id','دسته بندی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone1','شماره ها') ?></th>
                <th scope="col"><?= $this->Paginator->sort('level','سطح بندی') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('map_url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopLogestics as $shopLogestic): ?>
            <tr>
                <!-- <td><?= $this->Number->format($shopLogestic->id) ?></td> -->
                <td width="50" class="p-0"><?=$this->html->image($shopLogestic->image,[
                    'style'=>'max-width:100px;max-height:100px;border-radius:5px;']) ?>
                </td>

                <td><?= h($shopLogestic->title) ?> <?= h($shopLogestic->enable == 1)?
                        '<span class="badge badge-success">فعال</span>':'<span class="badge badge-danger">غیرفعال</span>'?>
                    <div class="hidme">
                        <?php $this->Html->link(__('View'), ['action' => 'view', $shopLogestic->id]) ?>
                        <?= $this->Html->link(__('کاربران'), [
                            'controller'=>'Logesticusers',
                            'action' => 'index', $shopLogestic->id
                            ]) ?>

                        <?= $this->Html->link(__('سفارش ها'), [
                            'controller'=>'Orderlogestics',
                            'action' => 'index', $shopLogestic->id
                            ]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'add', $shopLogestic->id]) ?>
                        <?= $this->Form->postLink(__('حذف'), ['action' => 'delete', $shopLogestic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopLogestic->id)]) ?>
                    </div>
                </td>
                <td><?= h($shopLogestic->descr) ?></td>
                <td><?= h($shopLogestic->address) ?></td>
                <td><?= $shopLogestic->has('shop_logesticlist') ? $this->Html->link($shopLogestic->shop_logesticlist->title, ['controller' => 'ShopLogesticlists', 'action' => 'view', $shopLogestic->shop_logesticlist->id]) : '' ?></td>
                <td style="direction:ltr;">
                    <?= h($shopLogestic->phone1) ?><br>
                    <?= h($shopLogestic->phone2) ?><hr>
                    <?= h($shopLogestic->mobile1) ?><br>
                    <?= h($shopLogestic->mobile2) ?>
                </td>
                <td><?= h($shopLogestic->level) ?></td>
                <!-- <td><?= h($shopLogestic->map_url) ?></td>
                <td><?= h($shopLogestic->location) ?></td> -->
                <td><?= $this->Func->date2($shopLogestic->created) ?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
