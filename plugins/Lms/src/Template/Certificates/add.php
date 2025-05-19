<?php use Lms\Predata;$predata = new Predata;?>
<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('مدیریت کد تخفیف') ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none">
    </div>
</div>

<div class="card"><div class="card-body">
    <?= $this->Form->create($lmsCertificate) ?>
    <fieldset>
        <legend><?= __('Add Lms Certificate') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('lms_course_id', ['options' => $lmsCourses]);
            echo $this->Form->control('input_data');
            echo $this->Form->control('image');
            echo $this->Form->control('download');
            echo $this->Form->control('status');
            echo $this->Form->control('enable');
            echo $this->Form->control('accepted', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div></div>