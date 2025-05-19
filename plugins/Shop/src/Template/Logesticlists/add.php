<?= $this->Form->create($shopLogesticlist,['class'=>'col-sm-6']) ?>
<fieldset>
    <legend><?= __('مدیریت دسته بندی') ?></legend>
    <?php
        echo $this->Form->control('title',[
            'label'=>'عنوان دسته بندی',
            'class'=>'form-control mb-2 '
        ]);
        echo $this->Form->control('enable',[
            'type'=>'select',
            'options'=>$this->Func->Predata('yesno'),
            'label'=>'وضعیت نمایش',
            'class'=>'form-control mb-2 '
        ]);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success']);?>
<?= $this->Form->end() ?>