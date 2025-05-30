    <?= $this->Form->create($challengefield,['class'=>'col-6']) ?>
    <fieldset>
        <legend><?= __('افزودن حوزه ماموریت') ?></legend>
        <?php
            echo $this->Form->control('title',[
                'type'=>'text',
                'label'=>'عنوان',
                'class'=>'form-control'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
