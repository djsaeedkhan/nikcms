<?php
if(
    isset($results['LmsExams']['options']) and 
    $results['LmsExams']['options'] != "" and
    isset($history[0]['result']) and $history[0]['result'] != 2
    ){
    $options = json_decode($results['LmsExams']['options'],true);
    if(isset($options['can_exampay']) and $options['can_exampay'] != ""){
        echo '<div class="mt-1">';
        foreach([1,2,3,4,5] as $time_again):
            if(
                ( $exampaylist + 1 ==  $time_again) and
                isset($options['again'][$time_again.'m_number']) and
                $options['again'][$time_again.'m_number'] != "" and
                $options['again'][$time_again.'m_title'] != ""
                ){
                    echo '<div class="mb-1">'.((isset($options['can_exampay_alert']) and $options['can_exampay_alert'] != "")?
                        $options['can_exampay_alert']:'').'</div>';
                    echo $this->Form->postlink(
                        $options['again'][$time_again.'m_title'],
                        '/lms/client/renewExam/'. $course_id.'/'.$results['LmsExams']['id'],
                        ['confirm'=>'آیا مطمین هستید؟',
                        'target'=>'_blank',
                        'class'=>'btn btn-danger']);
            }
        endforeach;
        echo '</div>';
    }
}?>