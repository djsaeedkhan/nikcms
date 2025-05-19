<?= $this->Form->create($shopLogestic,['class'=>'col-sm-6']) ?>
<fieldset>
    <legend><?= __('ثبت واحد ') ?></legend>
    <?php
        echo $this->Form->control('title',[
            'label'=>'عنوان واحد',
            'class'=>'form-control mb-2']);

        echo $this->Form->control('descr',[
            'label'=>'توضیحات',
            'class'=>'form-control mb-2',
            'type'=>'textarea']);

        echo $this->Form->control('address',[
            'label'=>'آدرس',
            'class'=>'form-control mb-2',
            'type'=>'textarea']);

        echo $this->Form->control('shop_logesticlist_id', [
            'options' => $shopLogesticlists,
            'label'=>'انتخاب دسته بندی '.$this->html->link(' [مدیریت]','/admin/shop/logesticlists/'),
            'escape'=>false,
            'empty'=>'-- --',
            'class'=>'form-control mb-2',
        ]);

        echo $this->Form->control('image',[
            'class'=>'form-control mb-2 ltr',
            'placeholder'=>'https://',
            'label'=>'آدرس تصویر']);
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $this->Form->control('phone1',[
                    'class'=>'form-control mb-2 ltr',
                    'label'=>'شماره تلفن 1']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('phone2',[
                    'class'=>'form-control mb-2 ltr',
                    'label'=>'شماره تلفن 2']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('mobile1',[
                    'class'=>'form-control mb-2 ltr',
                    'label'=>'شماره موبایل 1']);?>
            </div>

            <div class="col-sm-6">
                <?= $this->Form->control('mobile2',[
                    'class'=>'form-control mb-2 ltr',
                    'label'=>'شماره موبایل 2']);?>
            </div>

        </div>

        <?php
        echo $this->Form->control('level',[
            'class'=>'form-control mb-2',
            'label'=>'سطح فعالیت']);

        echo $this->Form->control('enable',[
            'label'=>'وضعیت نمایش',
            'type'=>'select',
            'class'=>'form-control mb-2',
            'options'=>$this->Func->Predata('yesno')]);

        echo $this->Form->control('map_url',[
            'class'=>'form-control mb-2 ltr',
            'label'=>'آدرس نقشه']);

        echo $this->Form->control('location',[
            'class'=>'form-control mb-2 ltr',
            'label'=>'مکان روی نقشه']);
    ?>
</fieldset>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-success']);?>
<?= $this->Form->end() ?>
