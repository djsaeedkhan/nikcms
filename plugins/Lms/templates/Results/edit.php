<?php
use Lms\Predata;
$p = new Predata();?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('ویرایش وضعیت') ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>

<?= $this->Form->create($lmsExamresult) ?>
<fieldset>
    <?= $this->Form->control('descr',['label'=>'توضیحات علت تغییر وضعیت ','type'=>'textarea']);?>
    <?= $this->Form->control('result',['label'=>'وضعیت','type'=>'select',
        'escape'=>false,
        'options'=> $p->gettype('exam_result') ]);?>
</fieldset>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
<?= $this->Form->end() ?>
<style>.input{margin-bottom:20px;}</style>