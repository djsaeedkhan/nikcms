<?= $this->Form->create($challengetext) ?>
<fieldset>
    <legend><?= __('مدیریت توضیحات') ?></legend>
    <?php
        //echo $this->Form->control('challenge_id', ['options' => $challenges]);
        echo $this->Form->control('title',[
            'class'=>'form-control',
            'style'=>'min-height:300px;',
            //'id'=>'pubEditor',
            'label'=>false
        ]);
        //echo $this->Form->control('types');
    ?>
</fieldset><br>
<?= $this->Form->submit(__('ثبت اطلاعات'),['class'=>'btn btn-sm btn-success']) ?>
<?= $this->Form->end() ?>
