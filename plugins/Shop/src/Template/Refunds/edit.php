<?php 
use Shop\View\Helper\CartHelper;
use Shop\View\Helper\PaymentHelper;
use Shop\View\Helper\ShopHelper;
$pp = new Shop\ProvinceCity();?>

<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    تغییر وضعیت مرجوعی
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($refund,['class'=>'col-md-6 col-sm-12']) ; ?>
        <div class="row">
            <div class="col-sm-4">
                <?= $this->Form->control('status', [
                    'label'=>'وضعیت مرجوعی',
                    'class'=>'form-control mb-1',
                    'options' => CartHelper::Predata('order_refundtype')]);?>
            </div>
            
            <div class="col-sm-5">
                <?= $this->Form->control('types', [
                    'label'=>'نوع مرجوعی',
                    'disabled',
                    'class'=>'form-control mb-1',
                    'options' => CartHelper::Predata('order_refund')]);?>
            </div>

            <div class="col-sm-3">
                <?= $this->Form->control('enable', [
                    'label'=>'باز بودن مرجوعی',
                    'class'=>'form-control mb-1',
                    'options' => CartHelper::Predata('enable')]);?>
            </div>
        </div>
        <?php
        echo $this->Form->control('descr', [
            'label'=>'توضیحات مرجوعی',
            'class'=>'form-control',
            'type'=>'textarea',
            'style'=>'min-height:100px',
            'default'=> $refund['descr'],
            'readonly'=>true ]);
        ?>

</div></div>
    <?= $this->Form->button(__('Submit'),['class'=>'mb-1 btn btn-success']) ?>
    <?= $this->Form->end() ?>

<style>
    .checkbox input{
        margin-left: 10px;
    }
</style>