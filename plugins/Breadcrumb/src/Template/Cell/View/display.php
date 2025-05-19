<?php
//use Cake\I18n\I18n;
//echo I18n::getLocale();

global $is_status;
use \Admin\View\Helper\ModuleHelper;
$setting = [];
if(($setting = $this->Func->OptionGet('brcrumb_plugin')) != ''){
    $setting = unserialize($setting);
}
if(! isset($setting['exclude_index']))
    $setting['exclude_index'] = [];

if(! isset($setting['exclude_single']))
    $setting['exclude_single'] = [];

if($action == 'single' and $is_status=='single' and !isset($setting['exclude_single'][$post_type]) ):

    echo $div != ''?'<'.$div.' '.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>':'';
    echo $this->Html->link( ((isset($setting['title_home']) and $setting['title_home']!='')?$setting['title_home']:
    __d('breadcrumb', 'صفحه نخست')) ,'/');

    echo $div != ''? '</'.$div.'>':'';
    echo $split;

    if(isset($post_type) and !isset($exclude[$post_type])){
        $ptype = ModuleHelper::post_type();
        if(isset($ptype[$post_type]['name']['index_header'])){
            echo '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.
            $this->Html->link($ptype[$post_type]['name']['index_header'],'/index/'.$post_type).
            '</'.$div.'>'.$split;
        }
    }

    if(isset($temp['categories']) and count($temp['categories'])){
        $i=1;
        $category = $temp['categories'];
        foreach($category as $cat):
            echo '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.
                $this->Query->permalink($cat['title'],$cat,['type'=> 'index']).($i != count($category)?' , ':'').
                '</'.$div.'>'.$split;
            $i+=1;
        endforeach;
    }
    if(intval($current))
    echo $temp['title'] != ''? '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.$temp['title'].'</'.$div.'>'.$split :'';

    if(isset($setting['title_single']) and $setting['title_single']!='' ){
        echo '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.($setting['title_single']).'</'.$div.'>';
    }

endif;

if($action == 'search'):

    echo $div != ''?'<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>':'';
    echo $this->Html->link( ((isset($setting['title_home']) and $setting['title_home']!='')?
        $setting['title_home']:
        __d('breadcrumb', 'صفحه نخست')
        ) ,'/');
    echo $div != ''? '</'.$div.'>':'';
    echo $split;

    echo '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.((isset($setting['title_search']) and $setting['title_search']!='')?$setting['title_search']:__d('breadcrumb', 'جستجو')).'</'.$div.'>';
    
    if($current)
    echo $temp!= '' ?$split.'<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.$temp.'</'.$div.'>' :'';
endif;

if($action == 'tag'):

    echo $div != ''?'<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>':'';
    echo $this->Html->link( ((isset($setting['title_home']) and $setting['title_home']!='')?$setting['title_home']:
    __d('breadcrumb', 'صفحه نخست') ),'/');
    echo $div != ''? '</'.$div.'>':'';
    echo $split;

    echo '<'.$div.'>'.((isset($setting['title_tag']) and $setting['title_tag']!='')?$setting['title_tag']:
        __d('breadcrumb', 'برچسب')).'</'.$div.'>';
    
    if($current)
    echo $temp != ''? $split. '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.$temp.'</'.$div.'>' :'';
endif;

if($action == 'index' and $is_status=='index' and !isset($setting['exclude_index'][$post_type])):
    echo $div != ''?'<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>':'';
    echo $this->Html->link( ((isset($setting['title_home']) and $setting['title_home']!='')?
        $setting['title_home']:
        __d('breadcrumb', 'صفحه نخست')) ,'/');
        
    echo $div != ''? '</'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>':'';
    echo $split != ''?$split:'';

    echo '<'.$div.(isset($options['div_class'])?' class="'.$options['div_class'].'" ':'').'>'.
        ((isset($setting['title_category']) and $setting['title_category']!='')?
        '<a href="#">'.$setting['title_category'].'</a>':
        '<a href="#">'.__d('breadcrumb', 'دسته بندی') .'</a>'
        ).
        '</'.$div.'>';

    if(isset($post_type) and ! in_array($post_type,$exclude)){
        $ptype = ModuleHelper::post_type();
        if(isset($ptype[$post_type]['name']['index_header']))
            echo ($split != ''?$split:'').'<'.$div.'>'.
            $this->Html->link(
                //$ptype[$post_type]['name']['index_header']
                $this->Query->the_category2()
                ,'/index/'.$post_type).
            '</'.$div.'>';
    }

    if($temp and $current){
        echo ($split != ''?$split:'');
        $result = $this->Query->category(null,['id'=>$temp,'get_type'=>'first']);
        echo '<'.$div.'>'.$this->Query->permalink($result['title'],$result,['type'=> 'category']).'</'.$div.'>';
    }
endif;

if($action == 'category'):

    echo $div != ''?'<'.$div.'>':'';
    echo $this->Html->link( ((isset($setting['title_home']) and $setting['title_home']!='')?
        $setting['title_home']:
        __d('breadcrumb', 'صفحه نخست')
        ) ,'/');
    echo $div != ''? '</'.$div.'>':'';
    echo $split;
    
    echo '<'.$div.'>'.((isset($setting['title_category']) and $setting['title_category']!='')?
        $setting['title_category']:
        __d('breadcrumb', 'دسته بندی')
        ).'</'.$div.'>';
    if(isset($post_type) and !isset($exclude[$post_type])){
        $ptype = ModuleHelper::post_type();
        if(isset($ptype[$post_type]['name']['index_header']))
            echo $split.'<'.$div.'>'.
            $this->Html->link($ptype[$post_type]['name']['index_header'],'/index/'.$post_type).
            '</'.$div.'>';
    }

    if($temp and $current){
        echo $split;
        $result = $this->Query->category(null,['id'=>$temp,'get_type'=>'first']);
        echo '<'.$div.'>'.$this->Query->permalink($result['title'],$result,['type'=> 'index']).'</'.$div.'>';
    }
endif;
?>