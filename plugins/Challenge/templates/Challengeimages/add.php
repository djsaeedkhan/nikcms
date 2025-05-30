<?= $this->Form->create($challengeimage) ?>
<fieldset>
    <legend><?= __('Add Challengeimage') ?></legend>
    <?php
        echo $this->Form->control('title');
        echo $this->Form->control('src');
        echo $this->Form->control('types',['options'=>[
            1=>'تصویر',
            2=>'فیلم']]);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>