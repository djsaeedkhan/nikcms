<?= $this->Form->create($challengeforumtitle) ?>
<fieldset>
    <legend><?= __('Edit Challengeforumtitle') ?></legend>
    <?php
        echo $this->Form->control('title');
        echo $this->Form->control('descr');
        echo $this->Form->control('priority');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
