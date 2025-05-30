<div class="lmsCourserelateds form large-9 medium-8 columns content">
    <?= $this->Form->create($lmsCourserelated) ?>
    <fieldset>
        <legend><?= __('Edit Lms Courserelated') ?></legend>
        <?php
            echo $this->Form->control('lms_course_id', ['options' => $lmsCourses]);
            echo $this->Form->control('lms_course_ids');
            echo $this->Form->control('types');
        ?>
    </fieldset>
    <?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
