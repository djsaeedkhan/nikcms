<h3><?= __d('Widget','مدیریت ابزارک');?></h3>
<div class="card cart1"><div class="card-body">
    <div class="table-responsive">
    <?php echo $this->Form->create($result,['class'=>'col-sm-6']);?>
    <h3 class="page-header">
        <?php echo $action==''?__d('Widget','ثبت جدید'):__d('Widget','به روز رسانی');?>
        <?php echo $this->Auths->link(
            __d('Widget','برگشت به صفحه اصلی'),
            ['action'=>'index'],
            ['class'=>'btn label label-default']);?>
    </h3>
    <?php
    echo $this->Form->control('id',['type'=>'hidden']);
    echo $this->Form->control('title',[
        'type'=>'text',
        'label'=>__d('Widget','عنوان ویجت'),
        'class'=>'form-control form-control-sm'
    ]);
    echo $this->Form->control('slug',[
        'type'=>'text',
        'label'=>__d('Widget','عنوان دسترسی'),
        'class'=>'form-control form-control-sm']);
    ?>
    <br>
    <?php
    echo $this->Form->control(
        __d('Widget','ثبت اطلاعات'),
        ['type'=>'submit','class'=>'btn btn-sm btn-success']);
    echo $this->Form->end();
    ?>
    </div>
</div></div>

