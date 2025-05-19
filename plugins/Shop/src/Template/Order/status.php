<?php 
use Shop\View\Helper\CartHelper;
$pp = new Shop\ProvinceCity();?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    تغییر وضعیت سفارش
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="row">
        <div class="col-sm-6">
            <?= $this->Form->create($order,[]) ; ?>
            <?php
            if(!is_array($order)){
                echo $this->Form->control('serial', [
                    'label'=>'سریال سفارش',
                    'class'=>'form-control mb-1',
                    'default'=> $order['trackcode'],
                    'readonly'=>true ]);
                    
                echo $this->Form->control('shipmentcode', [
                    'label'=>'شناسه مرسوله',
                    'class'=>'form-control mb-1 ltr' ]);
            }
            else{
                $list = [];
                foreach($order as $od)
                    $list[$od->id] = $od->trackcode;
                echo '<label>لیست سفارش ها</label><div class="ml-1">';
                echo $this->Form->select('order_id', $list, ['multiple' => 'checkbox','checked']);
                echo '</div><br>';
            }

            echo $this->Form->control('status', [
                'label'=>'وضعیت سفارش',
                'class'=>'form-control mb-1',
                'options' => CartHelper::Predata('order_status')]);
            ?>
        </div>

        <div class="col-sm-6">
            <div class="alert alert-primary">
                پس از تغییر وضعیت سفارش، به مشتری پیامک ارسال خواهد شد<br>
                متن پیامک ها از بخش، تنظیمات » پیامک ها ، قابل تغییر می باشد
            </div>
        </div>
        </div>

</div></div>

    
    <?= $this->Form->button(__('Submit'),['class'=>'mt-1 mb-1 btn btn-success']) ?>
    <?= $this->Form->end() ?>

<style>
    .checkbox input{
        margin-left: 10px;
    }
</style>