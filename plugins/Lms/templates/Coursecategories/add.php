<div class="card"><div class="card-body">
    <?= $this->Form->create($lmsCoursecategory,['class'=>'']) ?>
    <fieldset>
        <legend><?= __('مدیریت دسته بندی') ?></legend>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('title',[
                    'label'=>'عنوان دسته بندی',
                    'class'=>'form-control mb-1']);
                
                echo $this->Form->control('priority',[
                    'type'=>'number',
                    'label'=>'اولویت نمایش (فقط عدد)',
                    'class'=>'form-control mb-1 ltr']);

                echo $this->Form->control('descr',[
                    'type'=>'textarea',
                    'label'=>'توضیحات متنی',
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('image',[
                    'label'=>'تصویر پیشفرض',
                    'placeholder'=>'http://',
                    'class'=>'form-control mb-1 ltr']);
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('descr1',[
                    'label'=>'فیلد های اضافه 1',
                    'class'=>'form-control mb-1']);
                
                echo $this->Form->control('descr2',[
                    'label'=>'فیلد های اضافه 2',
                    'class'=>'form-control mb-1']);

                echo $this->Form->control('descr3',[
                    'label'=>'فیلد های اضافه 3',
                    'class'=>'form-control mb-1']).'<hr>';

                echo $this->Form->control('button',[
                    'label'=>'عنوان کلید  نمایش دوره ها',
                    'class'=>'form-control mb-1']);
                ?>
            </div>
        </div>
        
    </fieldset>
    <?= $this->Form->button(__('ثبت'),['class'=>'mt-2 btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div></div>
