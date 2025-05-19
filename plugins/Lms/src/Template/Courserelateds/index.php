<div class="lmsCourserelateds index large-9 medium-8 columns content">
    <h3><?= __('Lms Courserelateds') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lms_course_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lms_course_ids') ?></th>
                <th scope="col"><?= $this->Paginator->sort('types') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lmsCourserelateds as $lmsCourserelated): ?>
            <tr>
                <td><?= $this->Number->format($lmsCourserelated->id) ?></td>
                <td><?= $lmsCourserelated->has('lms_course') ? $this->Html->link($lmsCourserelated->lms_course->title, ['controller' => 'Courses', 'action' => 'view', $lmsCourserelated->lms_course->id]) : '' ?></td>
                <td><?= $this->Number->format($lmsCourserelated->lms_course_ids) ?></td>
                <td><?= $this->Number->format($lmsCourserelated->types) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('نمایش'), ['action' => 'view', $lmsCourserelated->id]) ?>
                    <?= $this->Html->link(__('ویرایش'), ['action' => 'Edit', $lmsCourserelated->id]) ?>
                    <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $lmsCourserelated->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsCourserelated->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
</div>

<?= $this->element('Admin.paginate')?>