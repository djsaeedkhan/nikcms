<div class="lmsExamusers view large-9 medium-8 columns content">
    <h3><?= h($lmsExamuser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $lmsExamuser->has('user') ? $this->Html->link($lmsExamuser->user->id, ['controller' => 'Users', 'action' => 'view', $lmsExamuser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lms Exam') ?></th>
            <td><?= $lmsExamuser->has('lms_exam') ? $this->Html->link($lmsExamuser->lms_exam->title, ['controller' => 'Exams', 'action' => 'view', $lmsExamuser->lms_exam->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Final Result') ?></th>
            <td><?= h($lmsExamuser->final_result) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lmsExamuser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= $this->Number->format($lmsExamuser->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $this->Func->date2($lmsExamuser->created) ?></td>
        </tr>
    </table>
</div>
