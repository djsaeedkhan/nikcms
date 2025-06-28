<?php
use Lms\Predata; $pd = new Predata();
$user = $results['user'];
$results = $results['lms_course'];
?>

<div class="content-header row">
    <div class="content-header-right col-md-10 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-right mb-0">
                    نمایش وضعیت
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb pt-0">
                        <span class="badge badge-success">
                            دوره: <?= $this->html->link($results['title'],
                                ['controller'=>'Courses','action'=>'view',$results['id'] ],
                                ['class'=>'text-white']);?>
                        </span>
                        &nbsp;&nbsp;
                        <?php if(isset($user->username)):?>
                            کاربر : <span class="badge badge-success" style="font-size:14px;">
                                <?=$this->html->link($user->username .($user->family!=''?' ('.$user->family.') ':''),
                                    ['controller'=>'user','action'=>'view',$user->id],
                                    ['class'=>'text-white','title'=>'نمایش مشخصات کاربر'])?>
                                </span>
                        <?php endif?>   
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-2 col-12 d-md-block d-none">
    </div>
</div>

<?= $this->Form->create(null,['type'=>'get']);?>
<?= $this->Form->button(__('همه موارد انتخاب شده افزوده شوند؟'),
    ['class'=>'btn btn-success mb-1','name'=>'submit','value'=>1,'confirm'=>'آیا موافق هستید موارد انتخاب شده افزوده شوند؟']) ?>

    <a class="select-me float-left">انتخاب همه هفته ها</a>

    <div class="accordion" id="accordion" role="tablist">
        <div class="row">
        <?php if($results['lms_courseweeks']):foreach ($results['lms_courseweeks'] as $temp): ?>
        <div class="col-6"><div class="card"><div class="card-body"><div>
            <div class="mb-2">
                <div class="card-header p-0">
                    <h4><a data-toggle="collapse" href="#co<?=$temp['id']?>" class="collapsed">
                        <?= $temp['title']?>
                    </a></h4>
                    <a class="select-me float-left">انتخاب هفته</a>
                </div><br>

                <div class="collapse show" id="co<?=$temp['id']?>" data-parent="#accordion">
                    
                    <ul class="list-group">
                        <?php 
                        if($temp['lms_coursefiles']):
                            foreach ($temp['lms_coursefiles'] as $temp2):
                                echo '<li class="list-group-item">';
                                echo $temp2['title']
                                    .(isset($can[$temp2['id']])?' <span class="badge badge-success">باز شده</span>':'');

                                echo '<br><br>';
                                foreach($session as $ss){if($ss['lms_coursefile_id'] == $temp2['id']){
                                    echo ' <span class="badge badge-secondary" style="direction: ltr;font-weight:normal">'.
                                        $this->Func->date2($ss['created']).
                                        '</span>';
                                }}
                                if(! isset($can[$temp2['id']])){
                                    echo $this->Form->checkbox($temp2['id'], ['hiddenField' => false,'class'=>'float-left checkboxAll','style'=>'margin-top: 5px;']);
                                    echo '<div class="float-left">&nbsp; | &nbsp;</div>';
                                    echo '<a href="?id='.$temp2['id'].'" title="افزودن به عنوان باز شده" class="float-left">باز شود</a>';
                                }
                                echo '</li>';

                                if(isset($temp2['lms_courseexams'][0]['lms_exam']['title'])){
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
                                }
                            endforeach;
                        endif;?>
                    </ul>
                </div>
            </div>
        </div>
        </div></div></div>
        <?php endforeach;endif;?>
        
    </div>
</div>

<script nonce="<?=get_nonce?>">
$(document).ready(function(){
    $(".select-me").click(function(){
        $(this).parent().parent().parent().find('.checkboxAll').each(function(){
            //alert("I");
            $(this).prop('checked', true);
        })
    });
});
</script>


<?= $this->Form->button(__('همه موارد انتخاب شده افزوده شوند؟'),
    ['class'=>'btn btn-success','name'=>'submit','value'=>1,'confirm'=>'آیا موافق هستید موارد انتخاب شده افزوده شوند؟']) ?>
<?= $this->Form->end() ?>