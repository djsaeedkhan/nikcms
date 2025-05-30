<?ph
use Cake\Routing\Router;
use Lms\Predata;$pd = new Predata();
?>
<?= $this->element('Lms.lms_modal');?>

<h3>
    آزمون های من
</h3>
<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col" width="50"><?= $this->Paginator->sort('','ردیف') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id','سریال آزمون') ?></th>
                <th scope="col">نمایش نتیجه</th>
                <th scope="col"><?= $this->Paginator->sort('lms_exam_id','آزمون') ?></th>
                <th scope="col"><?= $this->Paginator->sort('result','نتیجه نهایی') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','تاریخ شروع') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach ($lmsExamresults as $lmsExamresult): ?>
            <tr>
                <td><?= $i++ ;?></td>
                <td>
                    <?= $lmsExamresult->token ?>
                </td>
                <td>
                    <?php if(isset($lmsExamresult['lms_coursefile']['lms_courseexams'][0])){
                        $url = '/lms/client/exam/'.$lmsExamresult['lms_coursefile']['lms_courseexams'][0]['id'].'?result='.$lmsExamresult->token;
                        echo $this->Html->link(__('نمایش کارنامه آزمون'), $url ,
                            ['class'=>'btn btn-sm btn-light','data-toggle'=>'modal','data-target'=>'#exampleModalll',
                            'data-whatever'=>Router::url($url.'&nonav=1')]); 
                    }?>
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
