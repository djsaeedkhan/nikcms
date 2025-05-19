<h3><?= __d('Admin', 'مدیریت دسته بندی');?>: <?= h($category->title) ?></h3>
<div class="box box-primary">
    <div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row"><?=__d('Admin', 'پست تایپ') ?></th>
            <td><?= h($post_types = $category->post_type) ?></td>
        </tr>
        
        <tr>
            <th scope="row"><?=__d('Admin', 'والد') ?></th>
            <td><?= $this->Number->format($category->parent_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?=__d('Admin', 'تاریخ ثبت') ?></th>
            <td><?= $this->Func->date2($category->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?=__d('Admin', 'عنوان') ?></th>
            <td><?= $this->Text->autoParagraph(h($category->title)); ?></td>
        </tr>
        <tr>
            <th scope="row"><?=__d('Admin', 'نامک') ?></th>
            <td><?= $this->Text->autoParagraph(h($category->slug)); ?></td>
        </tr>
        <tr>
            <th scope="row"><?=__d('Admin', 'توضیحات') ?></th>
            <td><?= $this->Text->autoParagraph(h($category->description)); ?></td>
        </tr>
    </table></div>
    </div>
</div><br><br>