<?= $this->Form->create($challengestatus) ?>
<fieldset>
    <legend><?= __('Add Challengestatus') ?></legend>
    <?php
        echo $this->Form->control('title');
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>