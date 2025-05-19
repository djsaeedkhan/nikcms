<div class="lmsCourserelateds view large-9 medium-8 columns content">
    <h3><?= h($lmsCourserelated->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Lms Course') ?></th>
            <td><?= $lmsCourserelated->has('lms_course') ? $this->Html->link($lmsCourserelated->lms_course->title, ['controller' => 'Courses', 'action' => 'view', $lmsCourserelated->lms_course->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lmsCourserelated->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lms Course Ids') ?></th>
            <td><?= $this->Number->format($lmsCourserelated->lms_course_ids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Types') ?></th>
            <td><?= $this->Number->format($lmsCourserelated->types) ?></td>
        </tr>
    </table>
</div>
