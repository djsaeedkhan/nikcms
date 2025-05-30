<?php
use Cake\View\Cell;
use Cake\Routing\Router;
use Lms\Predata;
$pd = new Predata();?>
<h3>
    دوره: <?= $results['title'];?>
</h3>
<div class="card"><div class="card-body">
    
    <?php if($results['lms_courseweeks']):foreach ($results['lms_courseweeks'] as $temp): ?>
        <div class="table-responsive"><table class="table table-bordered">
        <tr>
            <td width="30%"><?= $temp['title']?></td>
            <td>
                <?php 
                if($temp['lms_coursefiles']):
                    foreach ($temp['lms_coursefiles'] as $temp2):
                        echo '<li class="list-group-item">';
                        echo $temp2['title'];

                        echo '<br><br>';
                        /* foreach($session as $ss){if($ss['lms_coursefile_id'] == $temp2['id']){
                            echo ' <span class="badge badge-secondary" style="direction: ltr;font-weight:normal">'.
                                $this->Func->date2($ss['created']).
                                '</span>';
                        }}
                        if(! isset($can[$temp2['id']])){
                            echo '<a href="?id='.$temp2['id'].'" title="افزودن به عنوان دیده شده" class="float-left">باز شود</a>';
                        } */
                        echo '</li>';

                        /* if(isset($temp2['lms_courseexams'][0]['lms_exam']['title'])){
                            echo '<li class="list-group-item ">';
                            echo 'آزمون : '.$temp2['lms_courseexams'][0]['lms_exam']['title'].' ';
                            if(isset($exam[$temp2['lms_courseexams'][0]['lms_exam']['id']])){
                                echo $pd->getvalue('exam_result', $exam[$temp2['lms_courseexams'][0]['lms_exam']['id']]);

                                echo $this->Html->link('[نمایش]', ['controller'=>'results','action' => 'view',
                                    $exam_result[$temp2['lms_courseexams'][0]['lms_exam']['id']]
                                ],['class'=>'mr-2']);
                            }

                            echo '<br><br>';
                            foreach($exam_all as $exm){
                                if($exm['lms_coursefile_id'] == $temp2['id']){
                                    echo '<table><tr>
                                        <td>'.$pd->getvalue('exam_result',$exm['result']).'</td>
                                        <td>'.$this->Func->date2($exm['created']).'</td>
                                        <td>'.$this->Html->link('[نمایش]', ['controller'=>'results','action' => 'view',$exm['id']]).'</td>
                                    </tr></table>';
                                }
                            }
                            echo '</li>';
                        } */
                    endforeach;endif;
                ?>
            </td></tr>
        </table></div>
    <?php endforeach;endif; ?>
</div></div>