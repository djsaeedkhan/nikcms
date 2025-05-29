<?php 
use Cake\Routing\Router;
use \Admin\View\Helper\ModuleHelper;
?>
<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
<?php
$posttype_title = unserialize($this->Func->OptionGet('posttype_title'));
$hidden = unserialize($this->Func->OptionGet('hide_posttype'));
$menu = ModuleHelper::admin_sidemenu();
ksort($menu);
foreach($menu as $k_menu => $v_menu):

    if(isset($v_menu['post_type']) and isset($posttype_title[$v_menu['post_type']]) and $posttype_title[$v_menu['post_type']] != ''){
        $v_menu['title'] = $posttype_title[$v_menu['post_type']];
    }
    if(isset($v_menu['post_type']) and is_array($hidden) and in_array($v_menu['post_type'],$hidden))
        continue;

    if($this->Auths->check($v_menu['link']) and $v_menu['show_in_menu']!= false): 
        $current = ($this->Func->admin_menu_is_current($k_menu , Router::url($this->request->getRequestTarget(), true)));
       
        if($v_menu['has_sub'] == true and count($v_menu['sub_menu'])):
            echo '<li class="nav-item has-sub nav-dropdown1 '.($current==1?'active open':'').'">';
            echo '<a href="#" class="d-flex align-items-center" aria-expanded="">
                <i class="ficon mr-50" data-feather="'.($v_menu['icon']!=''?$v_menu['icon']:'chevron-right').'"></i>'.
                $v_menu['title'].'<span class="fa arrow"></span>
                </a>';
            echo '<ul class="menu-content">';
            foreach($v_menu['sub_menu'] as $k_sub => $v_sub):
                if(isset($v_menu['link']['controller']) and $v_menu['link']['controller'] == 'plugins'){
                    echo '<li>'.
                    $this->html->link('<i data-feather="circle"></i><span class="menu-item text-truncate" >'.$v_sub['title'].'</span>',
                    $v_sub['link'],
                    ['class'=>'d-flex align-items-center','escape'=>false]).'</li>';
                }else{
                    echo '<li>'.
                        $this->Auths->link('<i data-feather="circle"></i><span class="menu-item text-truncate" >'.$v_sub['title'].'</span>',
                        $v_sub['link'],
                        ['class'=>'d-flex align-items-center','escape'=>false]).'</li>';
                }
                
                echo (isset($v_sub['after'])?$v_sub['after']:'');
            endforeach;
            echo '</ul>';
        else:
            echo '<li class="nav-item '.($current==1?'active open':'').'">';
            echo $this->html->link(
                '<i class="ficon mr-50" data-feather="'.($v_menu['icon']!=''?$v_menu['icon']:'chevron-right').'"></i>'.$v_menu['title'] ,
                $v_menu['link'],
                ['class'=>'d-flex align-items-center','escape'=>false]);
        endif;
        echo '</li>'.(isset($v_menu['after'])?$v_menu['after']:'');
    endif;
endforeach;
?>
</ul>
<br><br><br>