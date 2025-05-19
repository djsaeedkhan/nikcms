<?= $this->Form->create($challengeforum) ?>
<fieldset>
    <legend><?= __('Edit Challengeforum') ?></legend>
    <?php
        echo $this->Form->control('challenge_id', ['options' => $challenges]);
        echo $this->Form->control('challengeforumtitle_id', ['options' => $challengeforumtitles]);
        echo $this->Form->control('lft');
        echo $this->Form->control('rght');
        echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        echo $this->Form->control('text');
        echo $this->Form->control('enable');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
