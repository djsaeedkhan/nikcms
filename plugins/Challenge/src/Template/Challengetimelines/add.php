<?= $this->Form->create($challengetimeline) ?>
<fieldset>
    <legend><?= __('Add Challengetimeline') ?></legend>
    <?php
        echo $this->Form->control('title');
        echo $this->Form->control('types');
        echo $this->Form->control('dates');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>