<?php
use Cake\Routing\Router;
$sms = new \Sms\Sms();
?>
<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __d('Sms','افزونه پیامک');?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <?= $this->html->link('تنظیمات','/admin/sms/setting/',['class'=>'btn btn-sm btn-primary mx-1']);?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $today_sms;?></h2>
                    <p class="card-text"><?= __d( 'Sms', 'پیامک فرستاده شده امروز' ) ?></p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="message-square" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $month_sms;?></h2>
                    <p class="card-text"><?= __d( 'Sms', 'پیامک فرستاده شده این ماه' ) ?></p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="message-square" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="font-weight-bolder mb-0"><?= $total_sms;?></h2>
                    <p class="card-text"><?= __d( 'Sms', 'کل پیامک فرستاده شده' ) ?></p>
                </div>
                <div class="avatar bg-light-danger p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="message-square" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<h4>25 پیامک ارسال شده </h4>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id','ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile','شماره موبایل') ?></th>
                <th scope="col"><?= $this->Paginator->sort('message','متن پیامک') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sender','فرستنده') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0;foreach ($today_smslist as $result): ?>
            <tr>
                <td><?= ++$i;?></td>
                <td><?= h($result->mobile) ?></td>
                <td><?= nl2br($result->message) ?></td>
                <td><?= h($result->sender) ?></td>
                <td><?= $this->Func->date2($result->created);?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table></div>
</div></div>