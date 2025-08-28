    <?= $this->Form->create($challengequest) ?>
    <fieldset>
        <legend><?= __('ویرایش عنوان') ?></legend>
    <div class="row">
    <div class="col-sm-6">
        <?php
        echo $this->Form->control('title',[
            'class'=>'form-control',
            'label'=>'عنوان نمایشی',
            'type'=>'textarea']).'<br>';
        ?>
        <div class="row mb-1">
            <!-- <div class="col-sm-6">
                <?= $this->Form->control('types',[
                    'label' =>'نوع فیلد',
                    'empty'=> '-- --',
                    'required',
                    'default'=> false,
                    'options' => $types,
                    'class'=>'form-control']);?>
            </div> -->
            <div class="col-sm-12">
                <?= $this->Form->control('priority',[
                    'class'=>'form-control',
                    'label'=>'ترتیب نمایش (فقط عدد)',
                    'default'=>false,
                    'type'=>'number']);?>
            </div>
        </div>
</div>
<div class="col-sm-6">
<?php
        /* echo $this->Form->control('description',[
            'class'=>'form-control',
            'label'=>'توضیح مختصر']);
        echo '<div class="alert alert-primary">
        هر گزینه میتواند یک توضیح مختصر را نمایش بدهد</div>'; */
            
        /* echo $this->Form->control('parent_id', [
            'class'=>'form-control select2',
            'label'=>'زیرمجموعه',
            'options' => $parentChallengequests,'empty'=>'--']).'<br>'; */
        ?>
    </div>
</div>
</fieldset>
<?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>