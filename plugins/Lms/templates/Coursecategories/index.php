<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت دسته بندی دوره ها
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-sm btn-primary'])?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id','ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','عنوان') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descr','توضیحات') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsCoursecategories as $lmsCoursecategory): ?>
            <tr>
                <td><?= $this->Number->format($lmsCoursecategory->id) ?></td>
                <td><?= h($lmsCoursecategory->title) ?></td>
                <td><?= h($lmsCoursecategory->descr) ?></td>
                <td><?= $this->Func->date2($lmsCoursecategory->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('ویرایش'), ['action' => 'add', $lmsCoursecategory->id]) ?>
                    <?= $this->Form->postLink(__('حذف'), ['action' => 'delete', $lmsCoursecategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCoursecategory->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
