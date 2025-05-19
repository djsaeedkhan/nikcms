<?php
namespace Shop\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use SoapClient;

class PaymentHelper extends Helper
{
    public $helpers = ['Html','Form','Session'];
    ////////////////////////////////////////////////////////////////////////////////
    public static function getTerminal($id = null){
        //$html = new HtmlHelper(new \Cake\View\View());
        switch ($id) {
            case 'zarrinpal':
                return [
                    'image'=>'/shop/images/payments/zarinpal.png',
                    'slug' =>'zarrinpal',
                    'title'=>' توسط زرین پال'];
                break;
            case 'mellat':
                return [
                    'image'=>'/shop/images/payments/mellat.png',
                    'slug' =>'zarrinpal',
                    'title'=>'توسط بانک ملت'];
                break;
            case 'parsian':
                return [
                    'image'=>'/shop/images/payments/parsian.png',
                    'slug' =>'parsian',
                    'title'=>'توسط بانک پارسیان'];
                break;

            case 'fanava':
                return [
                    'image'=>'/shop/images/payments/FNV-Logo.png',
                    'slug' =>'fanava',
                    'title'=>'توسط فن آوا'];
                break;
            default:
                # code...
                break;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////
    public static function getPayment($token = null, $action = null){
        
    }
}