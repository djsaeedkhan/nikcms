<?= $this->Form->create($challengepartner,['class'=>'col-6']) ?>
<fieldset>
    <legend><?= __('بروز رسانی مشارکت کننده') ?></legend>
    <?php
        echo $this->Form->control('title',['label'=>'عنوان','class'=>'form-control mb-3']);
        echo $this->Form->control('link',['label'=>'آدرس لینک','type'=>'text','class'=>'ltr form-control mb-3']);
        echo $this->Form->control('image',['label'=>'آدرس تصویر','type'=>'text','class'=>'ltr form-control mb-3']);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>