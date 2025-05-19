<h3><?= __('افزودن مشتری جدید') ?></h3>
<div class="card cart1"><div class="card-body">
    <?= $this->Form->create($shopAddress,['class'=>'col-sm-6']) ?>
    <?php
        echo $this->Form->control('user_id', [
            'options' => $users, 
            'empty' => true,'class'=>'form-control mb-2',
            'label'=>'انتخاب کاربر']);
        echo $this->Form->control('first_name',['class'=>'form-control mb-2','label'=>'نام']);
        echo $this->Form->control('last_name',['class'=>'form-control mb-2','label'=>'نام خانوادگی']);
        echo $this->Form->control('emails',['class'=>'form-control ltr mb-2','label'=>'آدرس ایمیل']);
        echo $this->Form->control('phone',['class'=>'form-control ltr mb-2','label'=>'شماره تلفن']);
        echo $this->Form->control('nationalid',['class'=>'form-control ltr mb-2','label'=>'کدملی']);
        //echo $this->Form->control('shop_useraddress_id', ['options' => $shopUseraddresses]);
    ?>
    <?= $this->Form->button(__('Submit'),['class'=>'mt-1 mb-1 btn btn-success']);?>
    <?= $this->Form->end() ?>
</div></div>