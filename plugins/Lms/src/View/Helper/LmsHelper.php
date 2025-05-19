<?php
namespace Lms\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;

class LmsHelper extends Helper
{
    protected $_defaultConfig = [];
    public static $setting;
    //-----------------------------------------------------------------------------
    public static function GetAllSetting(){
        $result = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find( 'list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_lms'])
            ->toArray();
        self::$setting = isset($result['plugin_lms'])? unserialize($result['plugin_lms']) :[];
    }
    //-----------------------------------------------------------------------------
    public static function Setting($key = null) {
        if( self::$setting == null )
            LmsHelper::GetAllSetting();
        if( isset(self::$setting[$key]) )
            return self::$setting[$key];
        else
            return null;
    }
    //-----------------------------------------------------------------------------
    public static function PriceShow($price = null , $id = null ){
        if(is_numeric($price))
            return '<span id="price'.$id.'">'.number_format(intval($price)).'</span> '. 
                LmsHelper::CurrencyShow();
        else
            return '<span id="price'.$id.'">'.$price.'</span> '.
                LmsHelper::CurrencyShow();
    }
    //-----------------------------------------------------------------------------
    public static function CurrencyShow(){
        if(defined('lms_currency'))
            return lms_currency;
        else{
            define("lms_currency", LmsHelper::Predata('currency',LmsHelper::Setting('currency') ));
            define("lms_currency_name", LmsHelper::Setting('currency') );
            return lms_currency;
        }
    }
    //-----------------------------------------------------------------------------
    public static function Predata($input = null , $id = null){
        $temp = [];
        if($input == 'enable'){
            $temp = [
                1 => 'فعال',
                0 => 'غیرفعال',
            ];
        }
        if($input == 'currency_list'){
            $temp = [
                //'IRR' =>'ریال',
                //'IRHR' => 'هزار ریال',
                //'IRHT' => 'هزار تومان',
                'IRT' =>'تومان',
                'EUR'=>'یورو (€)',
                'IQD' => 'دینار عراق (ع.د)',
                'RUB' => 'روبل روسیه (₽)',
                'USD' => 'دلار آمریکا ($)',
            ];
        }

        if($input == 'currency'){
            $temp = [
                //'IRR' =>'ریال',
                //'IRHR' => 'هزار ریال',
                //'IRHT' => 'هزار تومان',
                'IRT' =>' تومان',
                'EUR'=>' €',
                'IQD' => ' دینار',
                'RUB' => ' ₽',
                'USD' => ' $',
            ];
        }
        if($input == 'terminal_list'){
            $temp = [
                //'mellat'=>'بانک ملت',
                '4' => 'زرین پال', //zarrinpal
                '2' => 'پارسیان', //parsian
                '3' => 'رسالت (سپ)', //sep
                '1' =>'بانک ملی (سداد)', //melli
            ];
        }

        if($id === null) 
            return $temp;
        elseif($id !== null and isset($temp[$id])) 
            return $temp[$id];
        else
            return '-';
    }
    
}