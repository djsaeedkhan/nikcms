<?php use Lms\Predata;$predata = new Predata;?>
<h3>
   نتیجه آزمون <!-- <?= $results['LmsExams']['title'];$exam = $results['LmsExams']; ?> -->
   <?= $this->html->link('مشاهده دوره',
        ['action'=>'courses',$course_id],
        ['class'=>'btn btn-success btn-sm'])?>

    <?= $this->html->link('برگشت به صفحه آزمون',
        ['action'=>'exam',$results['id']],
        ['class'=>'btn btn-success btn-sm'])?>
</h3>
<p>نام آزمون: <?= $results['LmsExams']['title'];?></p>
<div class="exam_result">
<div class="card"><div class="card-body">
    <?php 
        if($exam_result == 1){
        echo '<div class="alert alert-danger text-center">'.
            '<h3 style="font-size:18px;">شما در این آزمون قبول نشده اید</h3>';
        
        if(isset($history) and (count($history)- $exampay) >= $results['LmsExams']['reexam']){
            if( isset($history[0]['result']) and $history[0]['result'] != 2){
                echo '<div class="alert alert-'.$plugin_lms['exam_limit_try_type'].' pb-2">';
                if(isset($plugin_lms['exam_limit_try']) and $plugin_lms['exam_limit_try'] !=""):
                    echo $plugin_lms['exam_limit_try'];
                else:
                    echo 'با توجه به اتمام تعداد دفعات مجاز برای شرکت در آزمون،
                        <br><br> دیگر قادر به ادامه دادن دوره نیستید';
                endif;
            }
            include_once('exam_pay.php');
        }
        else
            echo '<br><br>'.$this->html->link('برای شروع آزمون جدید کلیک کنید','?',['class'=>'btn btn-success']);
        echo '</div>';
    }?>
    <?php if (!empty($lmsExamresult->lms_examresultlists)): ?>
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tr>
                <th scope="col"></th>
                <th scope="col"><?= __('عنوان سوال') ?></th>
                <?php if($exam_result==2):?>
                    <th scope="col"><?= __('گزینه صحیح') ?></th>
                <?php endif?>
                <th scope="col"><?= __('پاسخ شما') ?></th>
                <?php if($exam_result==2):?>
                    <th scope="col"><?= __('نتیجه سوال') ?></th>
                <?php endif?>
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
                <td style="width:60%;">
                    <?= isset($lmsExamresultlists['lms_examquest']['title'])?
                        $lmsExamresultlists['lms_examquest']['title'] :' - '; ?>
                    
                    <ul class="res px-0">
                        <?php 
                        for($q=1;$q<6;$q++):
                            if(isset($lmsExamresultlists['lms_examquest']['q'.$q]) and $lmsExamresultlists['lms_examquest']['q'.$q] ){
                                echo '<li>'.$lmsExamresultlists['lms_examquest']['q'.$q].'</li>';
                            }
                        endfor;?>
                    </ul>
                </td>
                <?php if($exam_result==2):?>
                    <td>
                        <?= isset($lmsExamresultlists['lms_examquest']['correct'])?$lmsExamresultlists['lms_examquest']['correct'] :' - ' ?>
                    </td>
                <?php endif?>
                <td>
                    <?= h($lmsExamresultlists->answer) ?>
                </td>
                

                <?php if($exam_result==2):?>
                    <td class="<?= $lmsExamresultlists->result==1?'bg-success text-white':''?> ">
                        <?= ($lmsExamresultlists->result===2)?'<span class="badge badge-danger">':'';?>
                        <?= $predata->getvalue('quest_result',$lmsExamresultlists->result)?>
                        <?= ($lmsExamresultlists->result===2)?'</span>':''?>
                    </td>
                <?php endif?>
            </tr>
            <?php endforeach; ?>
        </table></div>

        <br>
        <div class="table-responsive" style="width:70%;margin:0 auto"><table class="table table-bordered text-center table-light" style="margin: 0 auto;">
        <tbody><tr>
            <td class="px-4 py-2">تعداد کل سوالات: <?=count($lmsExamresult->lms_examresultlists)?></td>
            <td class="px-4 py-2">پاسخ صحیح: <?=$fail?></td>
            <td class="px-4 py-2">پاسخ منتظر: <?=$wait?></td>
            <td class="px-4 py-2">پاسخ غلط: <?= (count($lmsExamresult->lms_examresultlists) - $fail - $wait)?></td>
        </tr>
        <tr>
            <td class="px-4 py-2" colspan="4">
                وضعیت نتیجه آزمون :
                <strong><?=$predata->getvalue('exam_result',$lmsExamresult->result)?></strong>
            </td>
        </tr>
    </tbody></table></div>
<?php endif; ?>
    
</div></div>
</div>