<?php
use Lms\View\Helper\LmsHelper;
$lmsFactor = $factors[0];?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    جزئیات فاکتور #<?=$lmsFactor['id'];?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <!-- <?= $lmsFactor['paid']==0?
                        $this->Form->postlink('برای پرداخت کلیک کنید',
                            ['?'=>['id'=>$lmsFactor['id'],'payment'=>1]],
                            ['class'=>'btn btn-sm btn-success','confirm'=>'برای پرداخت مطمئن هستید؟'])
                    :''?> -->
                    <?= $lmsFactor['paid']==0?
                        $this->Html->link('پرداخت مجدد',
                            '/lms/client/factors?id='.$lmsFactor['id'],
                            ['class'=>'btn btn-sm btn-success'])
                    :''?>

                </div>
            </div>
            
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered">
            <tr>
                <th>مبلغ فاکتور</th>
                <td><?=  LmsHelper::PriceShow($lmsFactor->price) ?></td>
            </tr>
            <tr>
                <th>وضعیت پرداخت</th>
                <td><?= $lmsFactor->paid==0?
                        '<span class="badge badge-danger">پرداخت نشده</span>':
                        '<span class="badge badge-success">پرداخت شده</span>'; ?></td>
            </tr>
            <?php if(isset($lmsFactor['lms_userfactor']['lms_course']['id'])){?>
                <tr>
                    <th>نام دوره</th>    
                    <td><?= $lmsFactor['lms_userfactor']['lms_course']['title'] ?></td>
                </tr>
            <?php }?>
            <tr>
                <th>توضیحات</th>    
                <td><?= $lmsFactor->descr ?></td>
            </tr>
            <tr>
                <th>تاریخ ثبت فاکتور</th>
                <td><?= $this->Func->date2($lmsFactor->created) ?></td>
            </tr>
            
    </table></div>
</div></div><br>

<h2>تراکنش های مالی</h2>
<div class="card"><div class="card-body">
    <?php if(isset($lmsFactor['lms_payments']) and count($lmsFactor['lms_payments'])):?>
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">سریال پیگیری</th>
                <th scope="col">مبلغ</th>
                <th scope="col">وضعیت پرداخت</th>
                <th scope="col">درگاه پرداخت</th>
                <th scope="col">توضیحات</th>
                <th scope="col">تاریخ پرداخت</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsFactor['lms_payments'] as $payment):?>
            <tr>
                <td>
                    <?= ($payment->token) ?>
                </td>
                <td>
                    <?=  LmsHelper::PriceShow($payment->price) ?>
                </td>
                <td><?= $payment->enable==0?
                            '<span class="badge badge-danger">پرداخت نشده</span>':
                            '<span class="badge badge-success">پرداخت شده</span>'; ?></td>
                <td>
                    <?= LmsHelper::Predata('terminal_list', $payment->terminal_ids) ?></td>
                <td><?= $payment->Errtext ?></td>
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