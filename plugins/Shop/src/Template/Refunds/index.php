<?php use Cake\Routing\Router;
use Shop\View\Helper\ShopHelper;
use Shop\View\Helper\CartHelper;
$pp = new Shop\ProvinceCity();?>
<?= $this->element('Shop.shop_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    مدیریت مرجوعی
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card cart1"><div class="card-body1">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col" class="px-0 pt-2"></th>
                <th scope="col" class="pt-2"><?= $this->Paginator->sort('کدسفارش') ?></th>
                <th scope="col" class="pt-2"><?= $this->Paginator->sort('کاربر') ?></th>
                <th scope="col" class="pt-2"><?= $this->Paginator->sort('نوع مرجوعی') ?></th>
                <th scope="col" class="pt-2">توضیحات</th>
                <th scope="col" class="pt-2">وضعیت بررسی</th>
                <th scope="col" class="pt-2"><?= $this->Paginator->sort('تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php $i=1;foreach ($results as $result):?>
            <tr>
                <td class="p-0 pl-1">
                    <?= $i++?>
                </td>
                <td>
                    <?= isset($result->ShopOrders)?$result['ShopOrders']['trackcode']:'-';?>

                    <div class="hidme">
                        <?= $this->html->link(__('نمایش سفارش'),'/admin/shop/order/view/'.$result->shop_order_id,
                            ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                            'data-whatever'=>Router::url('/admin/shop/order/view/'.$result->shop_order_id.'?nonav=1') ]);?>

                        <?= $this->html->link(__('تغییر وضعیت'),'/admin/shop/refunds/edit/'.$result->id,
                            ['data-toggle'=>'modal','data-target'=>'#exampleModalll',
                            'data-whatever'=>Router::url('/admin/shop/refunds/edit/'.$result->id.'?nonav=1') ]);?>
                    </div>
                </td>

                <td>
                    <?= isset($result->user)?
                        $this->html->link($result['user']['username'],'/admin/users/view/'.$result['user']['id'],['target'=>'_blank']):
                        '-';?>
                </td>

                <td>
                    <?= CartHelper::Predata('order_refund',$result->types);?>
                    <?= ($result->enable==0)?'<span class="badge badge-danger">پایان یافته</span>':'' ?>
                </td>

                <td>
                    <?= h($result->descr)?>
                </td>

                <td>
                    <?= CartHelper::Predata('order_refundtype',$result->status);?>
                </td>

                <td>
                    <?= $this->Func->date2($result->created);?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>

<style>
    .table td{
        padding-right:15px;
        padding-left:15px;
        font-size:13px;
    }
</style>