<?= $this->Form->create($challengecat) ?>
<fieldset>
    <legend><?= 'ویرایش سطوح '.__d('Template', 'همیاری') ?></legend>
    <?php
        echo $this->Form->control('title');
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
