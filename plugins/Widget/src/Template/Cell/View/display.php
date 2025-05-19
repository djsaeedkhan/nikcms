<?php 
use Admin\View\Helper\ModuleHelper;
use Mpdf\Tag\Q;

foreach(json_decode($this->Func->OptionGet('site_widgetdata'),  true) as $side){

    
    if(isset($side[0]['sidebars']) and $side[0]['sidebars'] == $name){
        foreach($side as $sid){
            if(isset($sid['widget'])){
                $value = [];
                $field = "sidebar_" . $sid['name'];
                if($tmp = $this->Func->OptionGet($field)){
                    $value = json_decode(($tmp), true);
                }
                foreach($value as $k => $tp){
                    unset($value[$k]);
                    $value[ str_replace(['[',']',$field],'',$k) ] = $tp;
                }
                $sidebar = [];
                foreach(ModuleHelper::register_sidebars() as $temp ){
                    if(isset($temp['name']) and $temp['name'] == $name)
                        $sidebar = $temp;
                }
                if(isset($sidebar['before_div']) and $sidebar['before_div'] != '') echo $sidebar['before_div'];
                if(isset($value['title']) and $value['title'] != ''){
                    if(isset($sidebar['before_title']) and $sidebar['before_title'] != '') echo $sidebar['before_title'];
                    echo $value['title'];
                    if(isset($sidebar['after_title']) and $sidebar['after_title'] != '') echo $sidebar['after_title'];
                }
                echo $this->cell($sid['widget'],[$value , $sidebar]);
                if(isset($sidebar['after_div']) and $sidebar['after_div'] != '') echo $sidebar['after_div'];
            }
        }
    }
}
