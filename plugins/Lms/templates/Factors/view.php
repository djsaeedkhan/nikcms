<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    نمایش جزئیات فاکتور
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
            <th scope="row"><?= __('کاربر') ?></th>
            <td><?= $lmsFactor->has('user') ? $this->Html->link($lmsFactor->user->fname, ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $lmsFactor->user->id]) : '' ?></td>
        </tr>
        <!-- <tr>
            <th scope="row"><?= __('Lms Userfactor') ?></th>
            <td><?php // $lmsFactor->has('lms_userfactor') ? $this->Html->link($lmsFactor->lms_userfactor->id, ['controller' => 'LmsUserfactors', 'action' => 'view', $lmsFactor->lms_userfactor->id]) : '' ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('شماره فاکتور') ?></th>
            <td><?= ($lmsFactor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('کاربر ثبت کننده فاکتور') ?></th>
            <!-- <td><?= $this->Number->format($lmsFactor->user_ids); ?></td> -->
            <td><?= $lmsFactor->has('users') ? $this->Html->link($lmsFactor->users->fname, ['plugin'=>'Admin','controller' => 'Users', 'action' => 'view', $lmsFactor->users->id]) : '' ?></td>

        </tr>
        <tr>
            <th scope="row"><?= __('مبلغ') ?></th>
            <td>
                <?= $this->Number->format($lmsFactor->price) ?>
                <?= ($lmsFactor->coupons) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('وضعیت پرداخت') ?></th>
            <td><?= $predata->getvalue('paid',$lmsFactor->paid) ?></td>
        </tr>
       <!--  <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $predata->getvalue('paid',$lmsFactor->status) ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('تاریخ ثبت فاکتور') ?></th>
            <td><?= $this->Func->date2($lmsFactor->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('توضیحات') ?></th>
            <td><?= $this->Text->autoParagraph(h($lmsFactor->descr)); ?></td>
        </tr>
    </table></div>
</div></div>

       
<?php if (!empty($lmsFactor->lms_payments)): ?>
<h4><?= __('اقدام برای پرداخت') ?></h4>

    <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="col"><?= __('Id') ?></th>
            <!-- <th scope="col"><?= __('Lms Factor Id') ?></th> -->
            <th scope="col"><?= __('Token') ?></th>
            <th scope="col"><?= __('Price') ?></th>
            <th scope="col"><?= __('User Id') ?></th>
            <th scope="col"><?= __('Terminal Ids') ?></th>
            <th scope="col"><?= __('Auth') ?></th>
            <th scope="col"><?= __('RefID') ?></th>
            <th scope="col"><?= __('TraceID') ?></th>
            <th scope="col"><?= __('Errcode') ?></th>
            <th scope="col"><?= __('Errtext') ?></th>
            <th scope="col"><?= __('Status') ?></th>
            <th scope="col"><?= __('Enable') ?></th>
            <th scope="col"><?= __('Created') ?></th>
            <!-- <th scope="col" class="actions"><?= __('Actions') ?></th> -->
        </tr>
        <?php foreach ($lmsFactor->lms_payments as $lmsPayments): ?>
        <tr>
            <td><?= h($lmsPayments->id) ?></td>
            <!-- <td><?= h($lmsPayments->lms_factor_id) ?></td> -->
            <td><?= h($lmsPayments->token) ?></td>
            <td><?= h($lmsPayments->price) ?></td>
            <td><?= h($lmsPayments->user_id) ?></td>
            <td><?= h($lmsPayments->terminal_ids) ?></td>
            <td><?= h($lmsPayments->auth) ?></td>
            <td><?= h($lmsPayments->RefID) ?></td>
            <td><?= h($lmsPayments->TraceID) ?></td>
            <td><?= h($lmsPayments->Errcode) ?></td>
            <td><?= h($lmsPayments->Errtext) ?></td>
            <td><?= h($lmsPayments->status) ?></td>
            <td><?= h($lmsPayments->enable) ?></td>
            <td><?= h($lmsPayments->created) ?></td>
            <!-- <td class="actions">
                <?= $this->Html->link(__('نمایش'), ['controller' => 'LmsPayments', 'action' => 'view', $lmsPayments->id]) ?>
                <?= $this->Html->link(__('ویرایش'), ['controller' => 'LmsPayments', 'action' => 'edit', $lmsPayments->id]) ?>
                <?= $this->Form->postlink(__('حذف'), ['controller' => 'LmsPayments', 'action' => 'delete', $lmsPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsPayments->id)]) ?>
            </td> -->
        </tr>
        <?php endforeach; ?>
        </table></div>
    </div></div>
<?php endif; ?>