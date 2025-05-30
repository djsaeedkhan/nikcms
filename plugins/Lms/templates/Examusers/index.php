<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    کاربران آزمون
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
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lms_exam_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('final_result') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsExamusers as $lmsExamuser): ?>
            <tr>
                <td><?= $this->Number->format($lmsExamuser->id) ?></td>
                <td><?= $lmsExamuser->has('user') ? $this->Html->link($lmsExamuser->user->id, ['controller' => 'Users', 'action' => 'view', $lmsExamuser->user->id]) : '' ?></td>
                <td><?= $lmsExamuser->has('lms_exam') ? $this->Html->link($lmsExamuser->lms_exam->title, ['controller' => 'Exams', 'action' => 'view', $lmsExamuser->lms_exam->id]) : '' ?></td>
                <td><?= $this->Number->format($lmsExamuser->token) ?></td>
                <td><?= h($lmsExamuser->final_result) ?></td>
                <td><?= $this->Func->date2($lmsExamuser->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('نمایش'), ['action' => 'view', $lmsExamuser->id]) ?>
                    <?= $this->Html->link(__('ویرایش'), ['action' => 'Edit', $lmsExamuser->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $lmsExamuser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamuser->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>
