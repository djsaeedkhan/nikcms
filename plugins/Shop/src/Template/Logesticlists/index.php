<div class="content-header row">
    <div class="content-header-right col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title1 float-right mb-0">
                    دسته بندی نمایندگی 
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Auths->link('ثبت جدید',
                            ['action'=>'add'],['class'=>'btn btn-sm btn-primary']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordere1d table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id','ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','عنوان') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enable','وضعیت نمایش') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopLogesticlists as $shopLogesticlist): ?>
            <tr>
                <td><?= $this->Number->format($shopLogesticlist->id) ?></td>
                <td width="300"><?= h($shopLogesticlist->title) ?>
                    <div class="hidme">
                        <?php $this->Html->link(__('View'), ['action' => 'view', $shopLogesticlist->id]) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'add', $shopLogesticlist->id]) ?>
                        <?= $this->Form->postLink(__('حذف'), ['action' => 'delete', $shopLogesticlist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shopLogesticlist->id)]) ?>
                    </div>
                </td>
                <td><?= $shopLogesticlist->enable ?></td>
                <td><?= $this->Func->date2($shopLogesticlist->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>