    <?= $this->Form->create($shopLogesticuser,['class'=>'col-sm-6']) ?>
    <fieldset>
        <legend><?= __('افزودن کاربر جدید') ?></legend>
        <?php
            /* echo $this->Form->control('shop_logestic_id', [
                'label'=>'عنوان واحد',
                'class'=>'form-control mb-2',
                'options' => $shopLogestics]); */

            echo $this->Form->control('user_id', [
                'label'=>'عنوان کاربر',
                'empty'=>'-- --',
                'class'=>'form-control select2 mb-2',
                'options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>