<?php use Lms\View\Helper\LmsHelper;?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت پرداخت ها
                </h2>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <?php
 if(isset($payments) and count($payments)):?>
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">سریال پیگیری</th>
                <!-- <th scope="col">ش فاکتور</th> -->
                <th scope="col">مبلغ</th>
                <th scope="col">وضعیت پرداخت</th>
                <!-- <th scope="col">درگاه پرداخت</th> -->
                <th scope="col" style="width:25%">توضیحات</th>
                <th scope="col">تاریخ پرداخت</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment):?>
            <tr>
                <td>
                    <?= ($payment->token) ?>
                    <div class="hidme small">
                        <?= $this->html->link('نمایش فاکتور','/lms/client/factors?id='.$payment->lms_factor_id)?>
                    </div>
                </td>
                <!-- <td>
                    <?= ($payment->lms_factor_id) ?>
                    
                </td> -->
                
                <td>
                    <?= LmsHelper::PriceShow($payment->price) ?>
                </td>
                <td><?= $payment->enable==0?
                            '<span class="badge badge-danger">پرداخت نشده</span>':
                            '<span class="badge badge-success">پرداخت شده</span>'; ?></td>
                <!-- <td><?= $payment->terminal_ids ?></td> -->
                <td>
                    <?= isset($payment['lms_factor']['descr'])?
                        '<span class="fw-n badge badge-light-secondary">'.$payment['lms_factor']['descr'].'</span><br>':''?>
                    <?php // $payment->Errtext ?>
                </td>
                <td><?= $this->Func->date2($payment->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
    <?php
    else:
        echo '<div class="text-danger text-center">هنوز تراکنش / پرداخت ثبت نشده است</div>';
    endif?>
</div></div>