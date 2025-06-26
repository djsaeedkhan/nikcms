<?php
use Lms\Predata;
$p = new Predata();?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    <?= __('ویرایش پاسخ') ?>
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

<?= $this->Form->create($lmsExamresultlist);?>
<fieldset>
    <legend></legend>
    <div>
        پاسخ صحیح: <?=$lmsExamresultlist['LmsExamquests']['correct']?>
    </div><br>
    <?php
    switch ($lmsExamresultlist['LmsExamquests']['types']) {
        case 1:
            echo $this->Form->control('answer',['label'=>'پاسخ کاربر','type'=>'select',
            'options'=>[1=>1,2=>2,3=>3,4=>4,5=>5]]);
            break;
        default:
            echo $this->Form->control('answer',['label'=>'پاسخ کاربر','type'=>'textarea']);
            break;
    } ?>
    <?= $this->Form->control('result',['label'=>'نتیجه سوال','type'=>'select',
        'escape'=>false,
        'options'=> $p->gettype('quest_result') ]);?>
</fieldset>
<?= $this->Form->button(__('ثبت'),['class'=>'btn btn-sm btn-success']) ?>
<?= $this->Form->end() ?>
<style>.input{margin-bottom:20px;}</style>