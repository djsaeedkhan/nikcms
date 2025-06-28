<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت تخفیف ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="alert alert-light">
- تعداد استفاده شده  هر کدتخفیف بر اساس تعداد فاکتور پرداخت شده می باشد
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col" width="150"><?= $this->Paginator->sort('title','عنوان کدتخفیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('usage_limit_per_user','حداکثر استفاده کاربر') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('usage_limit_price','حداکثر مبلغ تخفیف') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('usage_count','حداکثر دفعات استفاده') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('maximum_amount','حداکثر تخفیف') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('discount_type','نوع تخفیف') ?></th>
                <th scope="col">آمار استفاده شده</th>
                <!-- <th scope="col" title="تاریخ انقضا کدتخفیف"></th> -->
                <th scope="col">
                    <?= $this->Paginator->sort('expiry_date','ت انقضا') ?>
                </th>
                <th scope="col">
                    <?= $this->Paginator->sort('created','ت ثبت') ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsCoupons as $lmsCoupon): ?>
            <tr>
                <td>
                    <?= ($lmsCoupon->title) ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش جزئیات'), ['action' => 'view', $lmsCoupon->id]) ?>
                        <?= $this->Form->postlink('حذف',
                            '/admin/lms/coupons/delete/'.$lmsCoupon->id,
                            ['confirm'=>'آیا موفق حذف این کدتخفیف می باشید؟ پس  از حذف امکان بازگشت اطلاعات وجود نخواهد داشت']);?>
                        <?= $this->Html->link('ویرایش','/admin/lms/coupons/add/'.$lmsCoupon->id);?>

                    </div>
                </td>
                <td><?= $this->Number->format($lmsCoupon->usage_limit_per_user) ?> بار</td>
                <!-- <td><?= $this->Number->format($lmsCoupon->usage_limit_price) ?></td> -->
                <td><?= $this->Number->format($lmsCoupon->usage_count) ?> بار</td>
                <td><?= $this->Number->format($lmsCoupon->maximum_amount)?><br><?= $predata->getvalue('discount_type',$lmsCoupon->discount_type) ?></td>
                <td><span class="badge badge-primary"><?= count($lmsCoupon->lms_factors) ?></span></td>
                <td>
                    <?= $this->Func->mil_to_shm($lmsCoupon->expiry_date->format('Y/m/d'),'/') ?>
                </td>
                <td>
                    <?= $this->Func->date2($lmsCoupon->created) ?>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
<?php // $this->element('Admin.paginate')?>
<style>
.table th, .table td {
    padding: 0.72rem 0rem;
    text-align: center;
}
</style>