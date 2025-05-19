<?php use Lms\Predata;$pd = new Predata();?>

<div class="content-header row">
    <div class="content-header-right col-md-8 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    نتایج آزمون
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-4 col-12 d-md-block">
        <?= $this->Form->create(null, ['type' => 'get','validate'=>false,'class'=>'col-sm-12']); ?>
            <div class="row float-left">
                <?= $this->Form->control('text', [
                    'label'=>false,
                    'type' => 'text', 
                    'class' => 'form-control form-control-sm',
                    'style'=>'width: 200px;',
                    'placeholder'=>'سریال آزمون، نام خانوادگی، نام کاربری',
                    'default'=>($this->request->getQuery('text')?$this->request->getQuery('text'):'') ]);?>
                <?= $this->Form->button(__('جستجو'),['class'=>'btn btn-sm btn-success ml-1']);?>
                <?php if($this->request->getQuery())
                    echo $this->html->link(__('حذف فیلتر'),['?'=>[]],['class'=>'btn btn-sm btn-warning ml-1']);?>
            </div>
        <?= $this->Form->end(); ?>
    </div>
</div>


<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <!-- <th scope="col" width="50"><?= $this->Paginator->sort('','ردیف') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('id','سریال آزمون') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id','مشخصات کاربری') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lms_exam_id','آزمون') ?></th>
                <th scope="col"><?= $this->Paginator->sort('result','نتیجه نهایی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ شروع') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($lmsExamresults as $lmsExamresult): ?>
            <tr>
                <!-- <td><?= $i++ ;?></td> -->
                <td>
                    <?= $lmsExamresult->token ?>
                    <div class="hidme">
                        <?= $this->Html->link(__('نمایش'), ['action' => 'view', $lmsExamresult->id]) ?>
                        <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lmsExamresult->id]) ?>
                        <?= $this->Form->postlink(__('Delete'), ['action' => 'delete', $lmsExamresult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lmsExamresult->id)]) ?> -->
                    </div>
                </td>
                <td>
                    <?= $lmsExamresult->has('user') ? $this->Html->link(
                        $lmsExamresult->user->username.($lmsExamresult->user->family!=''?' ('.$lmsExamresult->user->family.')':''), 
                        ['?'=>['user_id' => $lmsExamresult->user->id] ]) : '' ?>
                </td>
                
                <td style="width:300px;letter-spacing: -0.7px">
                    <?= isset($lmsExamresult['lms_coursefile']['lms_course'])?$lmsExamresult['lms_coursefile']['lms_course']['title'].' » ':''?>
                    <?= isset($lmsExamresult['lms_coursefile']['title'])?$lmsExamresult['lms_coursefile']['title'].' » ':''?>
                    <?= $lmsExamresult->has('lms_exam') ? $this->Html->link(
                        $lmsExamresult->lms_exam->title, 
                        ['?'=>['exam_id' => $lmsExamresult->lms_exam->id] ]) : '' ?>
                </td>
                <td>
                    <?= $pd->getvalue('exam_result',$lmsExamresult->result) ; ?>
                </td>
                <td><?= $this->Func->date2($lmsExamresult->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

<?= $this->element('Admin.paginate')?>