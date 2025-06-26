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
                <td><?php
                echo LmsHelper::PriceShow($lmsFactor->price);
                echo ($lmsFactor->coupons) ?>
                    <?= $lmsFactor->paid==0?
                        '<span class="badge badge-danger">پرداخت نشده</span>':
                        '<span class="badge badge-success">پرداخت شده</span>'; ?>
                </td>
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
            
    </table></div><br>
</div></div>

    <?php if($lmsFactor['paid']==0):?>
    <div class="row">
        <div class="col-sm-6"><div class="card"><div class="card-body">
            <?php
            if($lmsFactor['lms_coupon_id'] == ""):
                echo $this->Form->create(null,[
                    'url'=>\Cake\Routing\Router::url("",false),
                    'style'=>'display: flex;align-items: flex-start;']);
                echo '<label for="coupons" style="padding: 5px;">اعمال کد تخفیف</label>';
                echo $this->Form->control('coupons',[
                    'class'=>'form-control form-control-sm ltr',
                    'required',
                    'label'=>false]);
                echo $this->Form->button('اعمال',['class'=>'btn btn-sm btn-primary mx-1']);
                echo $this->Form->end();
            else:
                if(isset($lmsFactor['lms_coupon']['id'])):
                    echo 'نام کد تخفیف: '.$lmsFactor['lms_coupon']['title'].'<br>';
                    echo $this->Form->postlink('[حذف کدتخفیف]',
                        ['?'=>['id'=>$lmsFactor['id'],'coupons'=>"delete"]],
                        ['class'=>'text-danger','confirm'=>'برای حذف کدتخفیف مطمئن هستید؟']);

                else:
                    echo 'کد تخفیف استفاده شده نامعتبر می باشد';
                endif;
            endif;
            ?>
        </div></div></div>

        <div class="col-sm-6"><div class="card"><div class="card-body">
            <?= $this->Form->postlink('برای پرداخت فاکتور اینجا کلیک کنید',
                    ['?'=>['id'=>$lmsFactor['id'],'payment'=>1]],
                    ['class'=>'btn btn-sms btn-success','confirm'=>'برای پرداخت مطمئن هستید؟'])?>
        </div></div></div>
    </div>
    <?php endif?>

<br>

<h2>تراکنش های مالی</h2>
<div class="card"><div class="card-body">
    <?php if(isset($lmsFactor['lms_payments']) and count($lmsFactor['lms_payments'])):?>
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">شماره پرداخت</th>
                <th scope="col">مبلغ</th>
                <th scope="col">پرداخت شده</th>
                <th scope="col">درگاه پرداخت</th>
                <th scope="col">تاریخ ثبت</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsFactor['lms_payments'] as $payment): ?>
            <tr>
                <td>
                    <?= ($payment->token) ?>
                </td>
                <td><?= LmsHelper::PriceShow($payment->price) ?></td>
                <td><?= $payment->enable==0?
                            '<span class="badge badge-danger">ناموفق</span>':
                            '<span class="badge badge-success">موفق</span>'; ?></td>
                <td><?= LmsHelper::Predata('terminal_list',$payment->terminal_ids) ?></td>
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