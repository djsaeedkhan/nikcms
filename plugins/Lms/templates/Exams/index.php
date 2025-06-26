<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    مدیریت آزمون
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->html->link('افزودن',['action'=>'add'],['class'=>'btn btn-primary'])?>
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
                <th scope="col" width="400"><?= $this->Paginator->sort('descr','توضیحات') ?></th>
                <th scope="col"><?= $this->Paginator->sort('timer','مدت آزمون') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reexam','تعداد مجاز آزمون') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ ثبت') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsExams as $lmsExam): ?>
            <tr>
                <td><?= $this->Number->format($lmsExam->id) ?></td>
                <td>
                    <?= h($lmsExam->title) ?>
                    <div class="hidme">
                        <?php //$this->Html->link(__('مدیریت سوالات'), ['controller'=>'Examquests','action' => 'index', $lmsExam->id]) ?>
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $lmsExam->id]) ?>
                        <?= $this->Html->link(__('کپی'), ['action' => 'duplicate', $lmsExam->id],['confirm'=>'آیا موافق هستید؟']) ?>
                        <?= $this->Html->link(__('ویرایش'), ['action' => 'Add', $lmsExam->id]) ?>
                        <?php // $this->Form->postlink(__('حذف'), ['action' => 'delete', $lmsExam->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExam->id)]) ?>
                    </div>
                </td>
                <td><?= h($lmsExam->descr) ?></td>
                <td><?= $this->Number->format($lmsExam->timer) ?> دقیقه</td>
                <td><?= $this->Number->format($lmsExam->reexam) ?> دفعه</td>
                <td><?= $this->Func->date2($lmsExam->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>
<?= $this->element('Admin.paginate')?>