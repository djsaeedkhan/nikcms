<?php
use Lms\Predata;
use Cake\Routing\Router;
$pd = new Predata();
?>
<?= $this->element('Lms.lms_modal');?>

<div class="content-header row">
    <div class="content-header-right col-md-7 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                   نتیجه آزمون :  <?= '<span class="badge badge-success">'.$pd->getvalue('exam_result',$lmsExamresult->result).'</span>' ; ?>
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-5 col-12 d-md-block">
        <?= $this->Form->postlink(__('حذف'), 
            ['action' => 'delete', $lmsExamresult->id], 
            ['class'=>'btn btn-danger btn-sm float-left mr-2','confirm' => 'برای حذف مطمئن هستید؟']) ?>
            
        <?= $this->Html->link('ویرایش وضعیت آزمون','/admin/lms/results/edit/'.$lmsExamresult->id,
            ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-sm mx-1 btn-primary',
            'data-whatever'=>Router::url('/admin/lms/results/edit/'.$lmsExamresult->id.'?nonav=1')]);?>
    </div>
</div>


<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <tr>
            <th scope="row" width="200"><?= __('مشخصات کاربری') ?></th>
            <td><?= $lmsExamresult->has('user') ? $this->Html->link($lmsExamresult->user->username.($lmsExamresult->user->family!=''?' ('.$lmsExamresult->user->family.')':''), 
                ['controller' => 'User', 'action' => 'view', $lmsExamresult->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row">دوره آزمون</th>
            <td>
                <?= isset($lmsExamresult['lms_coursefile']['lms_course'])?$lmsExamresult['lms_coursefile']['lms_course']['title'].' » ':''?>
                <?= isset($lmsExamresult['lms_coursefile']['title'])?$lmsExamresult['lms_coursefile']['title']:''?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('نام آزمون') ?></th>
            <td><?= $lmsExamresult->has('lms_exam') ? 
                $this->Html->link($lmsExamresult->lms_exam->title, ['controller' => 'Exams', 'action' => 'view', $lmsExamresult->lms_exam->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('سریال آزمون') ?></th>
            <td><?= ($lmsExamresult->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('تاریخ آزمون') ?></th>
            <td><?=$this->Func->date2($lmsExamresult->created) ?></td>
        </tr>
    </table></div>
</div></div><br>

<?php if (!empty($lmsExamresult->lms_examresultlists)): ?>
    <div class="card"><div class="card-body">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"></th>
                <th scope="col"><?= __('عنوان سوال') ?></th>
                <!-- <th scope="col"><?= __('Token') ?></th> -->
                <th scope="col"><?= __('گزینه صحیح') ?></th>
                <th scope="col"><?= __('پاسخ کاربر') ?></th>
                <th scope="col"><?= __('نتیجه سوال') ?></th>
            </tr>
            <?php
            $fail = 0;
            $wait = 0;
            $i=1;
            foreach ($lmsExamresult->lms_examresultlists as $lmsExamresultlists):
                if($lmsExamresultlists['result'] === 2)
                    $wait += 1;
                elseif($lmsExamresultlists['result'] == 1)
                    $fail += 1;
                $correct = isset($lmsExamresultlists['lms_examquest']['correct'])?$lmsExamresultlists['lms_examquest']['correct']:null; ?>
            <tr>
                <td width="1"><?=$i++?></td>
                <td style="width:50%;">
                    <?= isset($lmsExamresultlists['lms_examquest']['title'])?
                        $lmsExamresultlists['lms_examquest']['title'] :' - '; ?>
                    
                    <ul class="res">
                    <?php 
                    for($q=1;$q<6;$q++):
                        if(isset($lmsExamresultlists['lms_examquest']['q'.$q]) and $lmsExamresultlists['lms_examquest']['q'.$q] )
                            echo '<li>'.$lmsExamresultlists['lms_examquest']['q'.$q].'</li>';
                    endfor;?>
                    </ul>
                </td>
                <td>
                    <?= isset($lmsExamresultlists['lms_examquest']['correct'])?$lmsExamresultlists['lms_examquest']['correct'] :' - ' ?>
                </td>
                <td>
                    <?= h($lmsExamresultlists->answer) ?>
                    <div class="hidme"><?= $this->Html->link('ویرایش','/admin/lms/results/editq/'.$lmsExamresultlists->id,
                        ['data-toggle'=>'modal','data-target'=>'#exampleModalll','title'=>'ویرایش پاسخ کاربر','class'=>'badge badge-primary text-white',
                        'data-whatever'=>Router::url('/admin/lms/results/editq/'.$lmsExamresultlists->id.'?nonav=1')]);?></div>
                </td>

                <!-- <td class="<?= ($correct!= null and $correct == $lmsExamresultlists->result)?'bg-success':''?> "> -->
                <td class="<?= $lmsExamresultlists->result==1?'text-white bg-success':''?> ">
                    <?= ($lmsExamresultlists->result===2)?'<span class="badge badge-danger">':'';?>
                    <?= $pd->getvalue('quest_result',$lmsExamresultlists->result)?>
                    <?= ($lmsExamresultlists->result===2)?'</span>':''?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table></div>

        <br>
        
    </div></div>


    <div class="card1"><div class="card-body1">
        <div class="table-responsive"><table class="1table table-bordered text-center" style="margin: 0 auto;">
            <tbody><tr>
                <td class="px-4 py-2">تعداد کل سوالات: <?=count($lmsExamresult->lms_examresultlists)?></td>
                <td class="px-4 py-2">پاسخ صحیح: <?=$fail?></td>
                <td class="px-4 py-2">پاسخ منتظر: <?=$wait?></td>
                <td class="px-4 py-2">پاسخ غلط: <?= (count($lmsExamresult->lms_examresultlists) - $fail - $wait)?></td>
            </tr>
            <tr>
                <td class="px-4 py-2" colspan="4">
                    وضعیت نتیجه آزمون :
                    <strong><?=$pd->getvalue('exam_result',$lmsExamresult->result)?></strong>
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2" colspan="4">
                    <?= $this->Html->link('ویرایش وضعیت آزمون','/admin/lms/results/edit/'.$lmsExamresult->id,
                        ['data-toggle'=>'modal','data-target'=>'#exampleModalll','class'=>'btn btn-primary',
                        'data-whatever'=>Router::url('/admin/lms/results/edit/'.$lmsExamresult->id.'?nonav=1')]);?>
                </td>
            </tr>
        </tbody></table></div>
    </div></div>
<?php endif; ?>

<style>ul.res li{list-style-position: inside;margin-right:10px;}</style>