<?php 
use Cake\Routing\Router;
use Shop\View\Helper\CartHelper;
$this->assign('shop_title','مرجوعی سفارش');
?>

<div class="container" style="direction:rtl;text-align:right">
    <?= $this->Form->create($refunds); ?>
    <?= $this->Form->control('types', ['label'=>'دلیل مرجوعی',
        'options' => CartHelper::Predata('order_refund'),
        'style'=>'font-size:14px;',
        'class' => 'form-control col-sm-6']); ?><br />
    <?= $this->Form->control('descr', [
        'label'=>'توضیحات علت مرجوعی',
        'style'=>'font-size:14px;',
        'type'=>'textarea','class' => 'form-control']); ?><br />
    <?php
    echo $this->form->submit('ثبت اطلاعات',['class'=>'btn btn-success btn-sm']);
    echo $this->Form->end(); ?>
</div>