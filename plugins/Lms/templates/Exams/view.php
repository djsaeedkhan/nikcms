
<?php use Cake\Routing\Router;?>
<?= $this->element('Lms.lms_modal');?>


<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    عنوان: <?= h($lmsExam->title) ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <?= $this->Html->link('ویرایش','/admin/lms/Exams/Add/'.$lmsExam->id,
                            ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary mx-1',
                            'data-whatever'=>Router::url('/admin/lms/Exams/Add/'.$lmsExam->id.'?nonav=1')]);?>

                        <?= $this->Form->postlink('حذف','/admin/lms/Exams/delete/'.$lmsExam->id,['class'=>'btn btn-sm btn-danger float-left',
                            'confirm'=>'با حذف، تمام سوالات و نتایج حذف خواهد شد. همچنین اطلاعات قابل بازیابی نخواهند بود']);?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block"></div>
</div>


<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row" width="200"><?= __('توضیحات') ?></th>
            <td><?= nl2br($lmsExam->descr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('مدت آزمون') ?></th>
            <td><?= $this->Number->format($lmsExam->timer) ?> دقیقه</td>
        </tr>
        <tr>
            <th scope="row"><?= __('تعداد مجاز آزمون') ?></th>
            <td><?= $this->Number->format($lmsExam->reexam) ?> دفعه</td>
        </tr>
        <tr>
            <th scope="row"><?= __('حداکثر تعداد جواب غلط') ?></th>
            <td><?= $this->Number->format($lmsExam->fail_count) ?> سوال غلط</td>
        </tr>
    </table></div>
</div></div><br>

<h4>
    <?= __('لیست سوالات آزمون') ?>
    <?= $this->Html->link('افزودن سوال جدید','/admin/lms/Examquests/Add/'.$lmsExam->id,
        ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary',
        'data-whatever'=>Router::url('/admin/lms/Examquests/Add/'.$lmsExam->id.'?nonav=1')]);?>

    <?= $this->Html->link('افزودن از فایل','/admin/lms/Examquests/Add/'.$lmsExam->id.'/?type=group',
        ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm btn-primary',
        'data-whatever'=>Router::url('/admin/lms/Examquests/Add/'.$lmsExam->id.'?nonav=1&type=group')]);?>
</h4>
<?php
if (!empty($lmsExam->lms_examquests)): ?>
    <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col" width="50"><?= __('اولویت نمایش') ?></th>
                <th scope="col" width="300"><?= __('عنوان سوال') ?></th>
                <th scope="col"><?= __('سوال 1') ?></th>
                <th scope="col"><?= __('سوال 2') ?></th>
                <th scope="col"><?= __('سوال 3') ?></th>
                <th scope="col"><?= __('سوال 4') ?></th>
                <th scope="col"><?= __('سوال 5') ?></th>
                <th scope="col" width="50"><?= __('گزینه صحیح') ?></th>
            </tr>
            <?php foreach ($lmsExam->lms_examquests as $lmsExamquests): ?>
            <tr>
                <td><?= h($lmsExamquests->priority) ?></td>
                <td <?=$lmsExamquests->types==0?'colspan="7"':''?>>
                    <?= $lmsExamquests->image!=''?$this->html->image($lmsExamquests->image,['style'=>'max-width:150px;max-height:150px;']):'' ?>
                    <?= ($lmsExamquests->title) ?><br>
                    <div class="hidme">
                        <?= $this->Html->link('ویرایش','/admin/lms/Examquests/Edit/'.$lmsExamquests->id,
                            ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'',
                            'data-whatever'=>Router::url('/admin/lms/Examquests/Edit/'.$lmsExamquests->id.'?nonav=1')]);?>
                        <?= $this->Form->postlink(__('Delete'), ['controller' => 'Examquests', 'action' => 'delete', $lmsExamquests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamquests->id)]) ?>
                    </div>
                </td>
                <?php
                switch ($lmsExamquests->types) {
                    case 0:break;
                    case 1: //یک انتخابی (Radio)
                        echo 
                       '<td>'.($lmsExamquests->q1 !=''?$lmsExamquests->q1:'-').'</td>
                        <td>'.($lmsExamquests->q2 !=''?$lmsExamquests->q2:'-').'</td>
                        <td>'.($lmsExamquests->q3 !=''?$lmsExamquests->q3:'-').'</td>
                        <td>'.($lmsExamquests->q4 !=''?$lmsExamquests->q4:'-').'</td>
                        <td>'.($lmsExamquests->q5 !=''?$lmsExamquests->q5:'-').'</td>
                        <td class="bg-success text-white">'.h($lmsExamquests->correct).'</td>';
                        break;

                    case 2: //چند انتخابی (Checkbox)
                        echo 
                       '<td>'.h($lmsExamquests->q1 !=''?$lmsExamquests->q1:'-').'</td>
                        <td>'.h($lmsExamquests->q2 !=''?$lmsExamquests->q2:'-').'</td>
                        <td>'.h($lmsExamquests->q3 !=''?$lmsExamquests->q3:'-').'</td>
                        <td>'.h($lmsExamquests->q4 !=''?$lmsExamquests->q4:'-').'</td>
                        <td>'.h($lmsExamquests->q5 !=''?$lmsExamquests->q5:'-').'</td>
                        <td></td>';
                        break;
                    default:
                        # code...
                        break;
                }?> 
            </tr>
            <?php endforeach; ?>
        </table></div>
    </div></div>
    <?php endif; ?>