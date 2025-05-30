<h3><?=__d('Widget','لیست ابزارک');?> "<?= $widget['title'];?>"</h3>
<div class="row">
    <div class="col-sm-4">
        <?= $this->Form->create($widget_form);?>
        <h3 class="page-header">
            <?= $action==''?__d('Widget','ثبت جدید'):__d('Widget','به روز رسانی');?>
            <?= $this->Auths->link(
                __d('Widget','برگشت به صفحه اصلی'),
                ['action'=>'index'],
                ['class'=>'btn label label-default']);?>
        </h3>
        <?php
        echo $this->Form->control('id',[
            'type'=>'hidden']);

        echo $this->Form->control('widgets_id',[
            'type'=>'hidden',
            'value'=>$widget['id']]);

        echo $this->Form->control('title',[
            'type'=>'text',
            'label'=>__d('Widget','عنوان ویجت'),
            'class'=>'form-control form-control-sm']);

        echo $this->Form->control('data',[
            'type'=>'textarea',
            'label'=>__d('Widget','متن اطلاعات'),
            'class'=>'form-control form-control-sm',
            'dir'=>'ltr']).'<br>';

        echo $this->Form->control(__d('Widget','ثبت اطلاعات'),[
            'type'=>'submit',
            'class'=>'btn btn-sm btn-success']);

        echo $this->Form->end();
        ?>
    </div>
    <div class="col-sm-8">
        <div class="card cart1"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($widget['widget_forms'] as $result): ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= h($result->title) ?>
                    <div class="row-actions"><span class="hidme">
                        <?= $this->Auths->link(__d('Widget','ویرایش'),
                            [$widget['id'],$result->id]);?>

                        <?= $this->Form->postlink(
                            __d('Widget','حذف'),
                            ['action'=>'Delete',$widget['id'],$result->id],
                            ['confirm'=>__d('Widget','آیا برای حذف مطمئن هستید؟')]);?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
        </div>
    </div>
</div>