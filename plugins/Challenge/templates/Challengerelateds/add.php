<?= $this->Form->create($challengerelated,['class'=>'col-sm-7']) ?>
<fieldset>
    <legend class="pb-2"><?= 'افزودن '.__d('Template', 'همیاری').' های مرتبط' ?></legend>
    <?php
        echo $this->Form->control('challenge_id',[
            'default'=>$id,
            'class'=>'d-none',
            'label'=>false
        ]);
        echo $this->Form->control('challenges_id', [
            'options' => $challenges,
            'id'=>'multiple1',
            'class'=>'form-control',
            'label'=> false,
            'style'=>'padding-right:10px;'
            //'multiple'
            ]);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
<style>
    #selectator_multiple1{
        padding-right: 20px !important;
    }
</style>
