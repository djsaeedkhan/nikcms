<?php
use Lms\Predata;
$predata = new Predata;
?>
<h3>
   عنوان : <?=$results['LmsExams']['title'];$exam = $results['LmsExams']; ?>

   <?= $this->html->link('مشاهده دوره',
        ['action'=>'courses',$course_id],
        ['class'=>'btn btn-secondary btn-sm'])?>
</h3>
<div class="card"><div class="card-body"><div class="row">
    <div class="col-sm-7">
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <td>
                        <strong>مهلت زمان شرکت در آزمون: </strong>
                        <span style="font-weight: normal;">
                            <?=$exam['timer']?> دقیقه
                        </span>
                    </td>
                </tr>
                
                <?php if($exam['descr'] != ""):?>
                <tr>
                    <td>
                        <strong>توضیحات</strong><br>
                        <div style="font-weight: normal;">
                            <?= nl2br($exam['descr'])?>
                        </div>
                    </td>
                </tr>
                <?php endif?>

                <tr>
                    <td>
                        <strong>تعداد مجاز شرکت در آزمون: </strong>
                        <span style="font-weight: normal;">
                            <?= $results['LmsExams']['reexam']?> دفعه
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>تعداد آزمون انجام شده توسط شما: </strong>
                        <span style="font-weight: normal;">
                            <?= count($history)?> دفعه
                        </span>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <strong>آزمون مجدد انجام شده با هزینه: </strong>
                        <span style="font-weight: normal;">
                            <?= ($exampaylist - $exampay)?> دفعه
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>آزمون مجدد باقیمانده با هزینه: </strong>
                        <span style="font-weight: normal;">
                            <?= ($exampay)?> دفعه
                        </span>
                    </td>
                </tr>

            </tbody>
        </table></div>
    </div>
    <div class="col-sm-5">
        <div class="alert alert-danger">
            توجه:<br>
            - به مهلت زمان آزمون توجه شود، پس از پایان زمان آزمون، حتی با زدن دکمه ثبت، پاسخ های شما ثبت نخواهد شد.
        </div>
    </div>
    </div>
</div></div>

<div class="text-center center">
    <?php
    $start = true;
    /* 
        pr("exampay: ".$exampay);
        pr("exampaylist: ". $exampaylist);
        pr("Hist: ". count($history));
        pr("Reexam: ". $results['LmsExams']['reexam']);
    */

    if($exampay == 0 and isset($history) and count($history) >= $results['LmsExams']['reexam']){
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

        echo '</div>';
        $start = false;
    }
    elseif( $exampay != 0 and count($history) < $results['LmsExams']['reexam'] + $exampaylist+$exampay ){

        echo '<div class="badge badge-light-success">
        برای شما فرصت اضافی جهت شرکت در آزمون در نظر گرفته شده است
        </div>';
        $start = true;

    }

    if($start == true)
        echo '<br><br>'.$this->html->link('برای شروع آزمون جدید کلیک کنید','?start=exam',['class'=>'btn btn-success'])?>
</div>

<h4>
   تاریخچه نتایج آزمون
</h4>
<div class="card"><div class="card-body">
    <?php 
    if(isset($history) and count($history)):?>
        <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <th width="50">ردیف</th>
                    <th width="250">تاریخ شرکت</th>
                    <th>نتیجه آزمون</th>
                    <th></th>
                </tr>
                <?php $i=1;foreach($history as $hist): ?>
                <tr>
                    <td><?= $i++?></td>
                    <td><?= $this->Func->date2($hist['created'])?></td>
                    <td><?= $predata->getvalue('exam_result',$hist['result']);//echo $hist['result']; ?></td>
                    <td><?php
                    if($hist['result'] != 0) 
                        echo $this->html->link('نمایش کارنامه آزمون','?result='.$hist['token'],['class'=>'btn btn-sm btn-light']);
                    else
                        echo $this->html->link('ادامه شرکت در آزمون','?starts='.$hist['token'],['class'=>'btn btn-sm btn-primary']);
                    ?></td>
                </tr>
                <?php endforeach?>
                
            </tbody>
        </table></div>
    <?php 
    else:
        echo 'رکوردی برای نمایش وجود ندارد';
    endif?>
</div></div>

<style>
.table td:first-child{font-weight: bold;}
.table th, .table td {border-top:0px solid #c2cfd6;}
</style>
