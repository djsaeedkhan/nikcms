<?php
use Cake\ORM\TableRegistry;
use Lms\Predata;
$pd = new Predata();
$this->LmsExamresults = $this->getTableLocator()->get('Lms.LmsExamresults');
?>

<div class="card"><div class="card-body">
    <div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr>
                <!-- <th scope="col">کدکاربری</th> -->
                <!-- <th scope="col">نام کاربری</th> -->
                <th scope="col">نام و نام خانوادگی</th>
                <th scope="col">تاریخ ثبت نام دوره</th>
                <th scope="col">بخش</th>
                <th scope="col">جلسه (دیده شده)</th>
                <th scope="col">آزمون ثبت شده</th>
                <th scope="col">وضعیت آزمون</th>
                <th scope="col" width="200">آخرین آزمون انجام شده</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $us):
                /* $coursefile = '-'; */
                /* $courseweek = '-'; */
                $exam_has =  0;
                $exam_succ = 0;
                if(isset($us['user']['lms_coursefilecans']) and count($us['user']['lms_coursefilecans'] )){
                    $filecan = $us['user']['lms_coursefilecans'];
                    if(isset($filecan[count($filecan)-1]) and $filecan[count($filecan)-1]['LmsCoursefiles']['lms_course_id'] == $id){
                        $f = $filecan[count($filecan)-1]['LmsCoursefiles'];

                        if(isset($f['lms_courseexams']) and count($f['lms_courseexams'])){
                            $exam_has = 1;
                            $exam = $this->LmsExamresults->find('all')
                                ->where(['lms_coursefile_id' => $f['id'] , 'user_id' => $us['user']['id']])
                                ->order(['id' =>'desc'])
                                ->first();
                            if($exam){
                                $exam_succ = $pd->getvalue('exam_result',$exam->result);
                            }
                        }

                        
                        /* if(isset($f['lms_courseweek']['title']))
                            $courseweek = $f['lms_courseweek']['title']; */

                       /*  $session = $this->getTableLocator()->get('Lms.LmsCoursesessions')->find('all')
                            ->where(['user_id'=> $us['user_id'],'LmsCoursesessions.lms_course_id'=> $us['lms_course_id'] ])
                            ->contain(['LmsCoursefiles'])
                            ->order(['lms_coursefile_id'=>'desc'])->first(); */

                        /* $coursefile = (strlen($f['title'])>2?
                        (isset( $session['LmsCoursefiles']['title'])? $session['LmsCoursefiles']['title']:$f['title'])
                        :'<span style="color:#F00">مرحله آزمون</span>'); */
                    }
                }?>
            <tr>
                <!-- <td width="100"><?php $us['user']['id']?></td>
                <td></td> -->
                <td><?php
                    $p = $this->getTableLocator()->get('Lms.LmsCoursesessions')->find('all')
                        ->where([
                            'LmsCoursesessions.user_id'=> $us['user']['id'] ,
                            'LmsCoursesessions.lms_course_id' => $us['lms_course_id'] ])
                        ->order(['LmsCoursesessions.lms_coursefile_id'=>'desc'])
                        ->contain(['LmsCoursefiles'=>['LmsCourseweeks']])
                        ->first();?>
                    <?= $us['user']['family']?>
                    <br>
                    <?= $this->html->link($us['user']['username'],
                        ['plugin'=>'lms','controller'=>'user','action'=>'view',$us['user']['id'] ])?>
                </td>
                <td><?=$this->Func->date2($us['created']) ?></td>
                <td><?= isset($p['LmsCourseweeks']['title'])?$p['LmsCourseweeks']['title']:'-'?></td>
                <td><?= isset($p['LmsCoursefiles']['title'])?$p['LmsCoursefiles']['title']:'-'?></td>
                <td><?= ( $exam_has == 0?'':'<i data-feather="check-circle" class="text-success"></i>')?></td>
                <td><?= $exam_succ == 0 ?'-':$exam_succ?></td>
                <td><?php
                    $coursefile = $this->getTableLocator()->get('Lms.LmsCoursefiles')->find('list',['keyField'=>'id','valueField'=>'id'])
                        ->where(['lms_course_id' => $us['lms_course_id']])
                        ->select(['id'])
                        ->toarray();

                    $exam = $this->LmsExamresults->find('all')
                        ->where([
                            'LmsExamresults.user_id' => $us['user']['id'],
                            'LmsExamresults.lms_coursefile_id IN'=> $coursefile
                            ])
                        ->contain(['LmsExams','LmsCoursefiles'])
                        ->order(['LmsExamresults.id' =>'desc'])
                        ->first();

                    if($exam){
                        echo isset($exam['lms_exam'])?
                            $this->html->link($exam['lms_exam']['title'],
                                ['controller'=>'Results','action'=>'view',$exam->id])
                            :'-';
                        echo '<br>';
                        echo '<b>'.$pd->getvalue('exam_result',$exam->result).'</b>';
                    }
                ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
</div></div>

    <?= $this->Html->script([
        'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js',
        'https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js',
        'https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        'https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js',
    ],['nonce'=>get_nonce])?>
    <script nonce="<?=get_nonce?>">
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            pageLength: 5000000000,
            buttons: [
                'copy', 'excel', 'pdf', 'print'
                ],
            language:
            {
                "sProcessing":      "در حال جستجو ...",
                "sSearch":          "جستجو: ",
                "sZeroRecords":     "چیزی پیدا نشد",
                "buttons": {
                    "print":    "پرینت",
                    "copy":     "کپی",
                    "pdf":'PDF',
                    "excel":'اکسل',
                }
            }
        });
    } );
    </script>
    <style>
        .dt-buttons{float:left}
        .dataTables_info, #example_paginate{display: none}
    </style>