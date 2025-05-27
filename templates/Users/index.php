<?php use Admin\View\Helper\ModuleHelper; ?>
<div class="alert alert-secondary"><?= __('خوش آمدید')?></div>

<div class="animated fadeIn">
    <div class="row match-height">
    <?php 
    $list  = (array) ModuleHelper::user_dashboard();
    while( count($list) > 0 ){
        foreach($list as $id => $widget){
            if($widget['order'] == 'hight2'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'hight'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'medium'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        foreach($list as $id => $widget){
            if($widget['order'] == 'low'){
                unset($list[$id]);
                echo $this->cell($widget['widget'],[$widget]);
            }
        }
        $list = [];
    }
    ?>
    </div>
</div>