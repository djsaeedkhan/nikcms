    <?= $this->Form->create($challengequest) ?>
    <fieldset class="col-6">
        <legend><?= __('ویرایش') ?></legend>
        <?php
        echo $this->Form->control('types',[
            'label' =>'نوع فیلد',
            'options'=> $types,
            'class'=>'form-control']).'<br>';
        
        echo '<div class="alert alert-info">
        فیلد <b>چندگزینه ای</b> امکان درج زیرمجموعه (زیرسوال) را دارد</div>';

        echo $this->Form->control('title',[
            'class'=>'form-control',
            'label'=>'عنوان',
            'type'=>'textarea']).'<br>';

        echo $this->Form->control('priority',[
            'class'=>'form-control',
            'label'=>'ترتیب',
            'type'=>'number']).'<br>';
            
        echo $this->Form->control('description',[
            'class'=>'form-control',
            'label'=>'توضیحات']).'<br>';
            
        echo $this->Form->control('parent_id', [
            'class'=>'form-control select2',
            'label'=>'زیرمجموعه',
            'options' => $parentChallengequests,'empty'=>'--']).'<br>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('ثبت اطلاعات'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>