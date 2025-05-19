<?= $this->Form->create($challengetag) ?>
<fieldset>
    <legend><?= __('Edit Challengetag') ?></legend>
    <?php
        echo $this->Form->control('title');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
