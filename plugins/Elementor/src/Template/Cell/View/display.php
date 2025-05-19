<?php
use Admin\View\Helper\ModuleHelper;
if($elements != ''){
   
    foreach(explode(',',$elements) as $elm){

        $cell = explode(':',$elm);
        if(isset($cell[0]) and $cell[0] != ''){

            $list = null;
            foreach(ModuleHelper::register_elementor() as $lists){
                if($lists['plugin'].'.'.$lists['name'] == $cell[0]){

                    $list = $lists;
                    if(isset($post_meta[$elm])){
                        global $Esetting;
                        $Esetting = $post_meta[$elm];
                        echo $this->cell($lists['site']);
                    }
                    else
                        echo '<!--  Setting For '.$elm.' Not Found --->';
                }
            }

        }else echo '<!--  المان مورد نظر پیدا نشد --->';
    }
}?>