<?php
if(isset($value['menu'])):
echo $this->Query->Navmenu($value['menu'],[
    'nav' => true,
    'nav_class'=> ((isset($value['nav_class']) and $value['nav_class']!= '')?$value['nav_class']:''),
    
    'div' => true,
    'div_class'=> ((isset($value['div_class']) and $value['div_class']!= '')?$value['div_class']:''),
    
    'ul'=> true,
    'ul_class'=> ((isset($value['ul_class']) and $value['ul_class']!= '')? $value['ul_class'] :''),
    
    'li_class'=> ((isset($value['li_class']) and $value['li_class']!= '')? $value['li_class'] :''),
    'a_class'=> ((isset($value['a_class']) and $value['a_class']!= '')? $value['a_class'] :''),
]);
echo '<div class="clearfix"></div>';
endif;
?>