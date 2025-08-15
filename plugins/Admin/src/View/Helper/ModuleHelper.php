<?php
namespace Admin\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Core\Plugin;

class ModuleHelper extends Helper
{
    public static $name = [];
    public static function post_type($n = null){
        if($n != null)
            static::$name += $n;
        else
            return static::$name;
    }
    // -------------------------------- 
    public static $shortcode = [];
    public static function shortcode($n = null){
        if($n != null)
            static::$shortcode += $n;
        else
            return static::$shortcode;
    }
    // -------------------------------- 
    public static $name2 = [];	
	public static function admin_sidemenu($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $k => $nn){
                    static::$name2[$k] = $nn;
                    //array_push(static::$name2, $nn);
                    //array_unshift($nn, static::$name2);
                }
            }
        }
        else{
            return static::$name2;
        }
    }
    // -------------------------------- 
    public static $name3 = [];	
	public static function admin_postwidget($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name3, $nn);
            }
        }
        else return static::$name3;
    }
    // -------------------------------- 
    public static $name4 = [];	
	public static function admin_catswidget($n = null){
        if($n != null) static::$name4 += $n;
        else return static::$name4;
    }
    // -------------------------------- 
    public static $name5 = [];	
	public static function admin_navmenu($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name5, $nn);
            }
        }
        else return static::$name5;
    }
    // -------------------------------- 
    public static $name5a = [];	
	public static function admin_dashboard($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name5a, $nn);
            }
        }
        else return static::$name5a;
    }
    // -------------------------------- 
    public static $user_dashboard = [];	
	public static function user_dashboard($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$user_dashboard, $nn);
            }
        }
        else return static::$user_dashboard;
    }
    // -------------------------------- 
    public static $name5p = [];	
	public static function admin_postcnt($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name5p, $nn);
            }
        }
        else return static::$name5p;
    }
    // -------------------------------- 
    public static $name6 = [];	
	public static function site_header($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name6, $nn);
            }
        }
        else return static::$name6;
    }
    // -------------------------------- 
    public static $name7 = [];	
	public static function site_footer($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name7, $nn);
            }
        }
        else return static::$name7;
    }
    // -------------------------------- 
    public static $var_notif = [];	
	public static function plugin_notification($n = null){
        if($n != null) static::$var_notif += $n;
        else return static::$var_notif;
    }
    // -------------------------------- 
    public static $name8 = [];	
	public static function site_preload($n = null){
        if($n != null) static::$name8 += $n;
        else return static::$name8;
    }
    // -------------------------------- 
    public static $name9 = [];	
	public static function register_sidebars($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name9, $nn);
            }
        }
        else return static::$name9;
    }
    // -------------------------------- 
    public static $name09 = [];	
	public static function register_elementor($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name09, $nn);
            }
        }
        else return static::$name09;
    }
    // -------------------------------- 
    public static $name10 = [];	
	public static function register_widgets($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn)
                array_push(static::$name10, $nn);
            }
        }
        else return static::$name10;
    }
    // -------------------------------- 
    public static $name11 = [];	
	public static function options_public($n = null){
        if($n != null) static::$name11 += $n;
        else return static::$name11;
    }
    // -------------------------------- 
    public static $name12 = [];	
	public static function options_userfield($n = null){
        if($n != null)
            static::$name12 += $n;
        else
            return static::$name12;
    }
    // -------------------------------- 
    public static $name1pf = [];	
	public static function options_profileuserfield(){
        foreach(static::$name12 as $k=>$ff){
            if(isset($ff['in_profile']) and $ff['in_profile'])
                static::$name1pf [$k] = $ff;
        }
        return static::$name1pf;
    }
    // -------------------------------- 
    public static $options_register = [];	
	public static function options_register($n = null){
        if($n != null) static::$options_register += $n;
        else return static::$options_register;
    }
    // --------------------------------
    public static $options_registerform = [];	
	public static function options_registerform($n = null){
        if($n != null) static::$options_registerform += $n;
        else return static::$options_registerform;
    }
    // --------------------------------
    public static $options_role = [];	
    public static function options_role($n = null){
        //pr(static::$options_role);
        if($n != null) static::$options_role[] = $n;
        else return static::$options_role;
    }
    // --------------------------------
    public static $excplgn = [];	
	public static function excplgn($n = null){
        if($n != null) static::$excplgn += $n;
        else return static::$excplgn;
    }
    // --------------------------------
    public static $registeration_after = [];	
	public static function registeration_after($n = null){
        if($n != null) static::$registeration_after += $n;
        else return static::$registeration_after;
    }
    // --------------------------------
    public static $registeration_before = [];	
	public static function registeration_before($n = null){
        if($n != null)
            static::$registeration_before += $n;
        else
            return static::$registeration_before;
    }
    // --------------------------------
    public static $post_elementor = [];	
	public static function post_elementor($n = null){
        if($n != null) static::$post_elementor += $n;
        else return static::$post_elementor;
    }
    // --------------------------------
    public static $cronjobs = [];	
	public static function register_cronjobs($n = null){
        if($n != null){
            if(count($n)){
                foreach($n as $nn) array_push(static::$cronjobs, $nn);
            }
        }
        else return static::$cronjobs;
    }
    // --------------------------------
    
}