<?php
if($status != "false"):
    if($result['title'] !=''){
        if($status == "link")
            echo '<a href="#" class="list-group-item pr-0 disabled">
                <i data-feather="lock" style="margin-left:5px;" title="قفل"></i>'.$result['title'].'</a>';
        else
            echo $this->html->link(
                $result['title'],
                '?file='.$result['id'],
                ['class'=>'list-group-item pr-0 text-body currents','style'=>'color: #5E50EE;'] );
    }
    
    if(isset($result['lms_courseexams'])):
        foreach($result['lms_courseexams'] as $temp3){
            echo isset($temp3['lms_exam']['title'])?
                '<a class="list-group-item '.($status == "true"?'':'disabled ').'"><span class="badge badge-'.($status == "true"?'primary':'secondary ').' mb-2">آزمون</span> '.
                ($status == "true"?$this->html->link($temp3['lms_exam']['title'],['action'=>'exam', $temp3['id']]):$temp3['lms_exam']['title'])
                .'</a>':null;
        }
    endif;
endif;