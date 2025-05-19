<?= $this->Form->create($challengetopic,['class'=>'col-6']) ?>
<fieldset>
    <legend><?= __('موضوعات') ?></legend>
    <?php
        echo $this->Form->control('title',[
            'label'=>false,
            'class'=>'form-control mb-2',
        ]);
        echo $this->Form->control('img',[
            'label'=>'آدرس تصویر','placeholder'=>'http://',
            'class'=>'form-control ltr mb-2',
        ]);
        echo $this->Form->control('descr',[
            'label'=>'توضیحات',
            'class'=>'form-control mb-2',
        ]);
    ?>
</fieldset><br>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>