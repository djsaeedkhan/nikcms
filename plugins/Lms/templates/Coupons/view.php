<?php use Lms\View\Helper\LmsHelper;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    نمایش جزئیات تخفیف
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row"><?= __('عنوان') ?></th>
            <td><?= h($lmsCoupon->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Type') ?></th>
            <td><?= h($lmsCoupon->discount_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usage Limit Per User') ?></th>
            <td><?= $this->Number->format($lmsCoupon->usage_limit_per_user) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usage Limit Price') ?></th>
            <td><?= $this->Number->format($lmsCoupon->usage_limit_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usage Count') ?></th>
            <td><?= $this->Number->format($lmsCoupon->usage_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Maximum Amount') ?></th>
            <td><?= $this->Number->format($lmsCoupon->maximum_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('تاریخ انقضا') ?></th>
            <td><?= $this->Func->date2($lmsCoupon->expiry_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('تاریخ ثبت') ?></th>
            <td><?= $this->Func->date2($lmsCoupon->created) ?></td>
        </tr>
        <!-- <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($lmsCoupon->modified) ?></td>
        </tr> -->

        <tr>
            <th scope="row"><?= __('اعمال روی محصول') ?></th>
            <td><?= $this->Text->autoParagraph(h($lmsCoupon->product_ids)); ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('اعمال روی دسته بندی') ?></th>
            <td><?= $this->Text->autoParagraph(h($lmsCoupon->product_categories)); ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('توضیحات') ?></th>
            <td><?= $this->Text->autoParagraph(h($lmsCoupon->descr)); ?></td>
        </tr>
    </table></div>
</div></div>

<div class="card"><div class="card-body">
    <h4><?= __('فاکتورهای استفاده شده') ?> ( <?= count($lmsCoupon->lms_factors)?> کل موارد )</h4>
    <?php if (!empty($lmsCoupon->lms_factors)): ?>
        <div class="alert alert-light">
        - تعداد استفاده شده  هر کدتخفیف بر اساس تعداد فاکتور پرداخت شده می باشد
        </div>
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="col"><?= __('کاربر') ?></th>
            <!-- <th scope="col"><?= __('User Ids') ?></th> -->
            <th scope="col"><?= __('مبلغ فاکتور') ?></th>
            <th scope="col"><?= __('مبلغ قبل از تخفیف') ?></th>
            <th scope="col"><?= __('پرداخت شده') ?></th>
            <th scope="col"><?= __('اعمال شده') ?></th>
            <th scope="col"><?= __('توضیحات') ?></th>
            <th scope="col"><?= __('تاریخ ثبت') ?></th>
        </tr>
        <?php foreach ($lmsCoupon->lms_factors as $lmsFactors): ?>
        <tr>
            <td><?= $lmsFactors->has('user') ? $this->Html->link($lmsFactors->user->fname, ['controller' => 'Users', 'action' => 'view', $lmsFactors->user->id]) : '' ?></td>
            <!-- <td><?= h($lmsFactors->user_ids) ?></td> -->
            <td>
                <?= LmsHelper::PriceShow($lmsFactors->price) ?>
                <div class="hidme">
                    <?= $this->Html->link(__('نمایش فاکتور'), ['controller' => 'Factors', 'action' => 'view', $lmsFactors->id]) ?>
                </div>
            </td>
            <td><?= LmsHelper::PriceShow($lmsFactors->old_price) ?></td>
            <td><?= $lmsFactors->paid==0?
                    '<span class="badge badge-danger">پرداخت نشده</span>':
                    '<span class="badge badge-success">پرداخت شده</span>'; ?>
            </td>
            <td><?= h($lmsFactors->status) ?></td>
            <td><?= h($lmsFactors->descr) ?></td>
            <td><?= $this->Func->date2($lmsFactors->created) ?></td>
            
        </tr>
        <?php endforeach; ?>
    </table></div>
    <?php endif; ?>
</div></div>