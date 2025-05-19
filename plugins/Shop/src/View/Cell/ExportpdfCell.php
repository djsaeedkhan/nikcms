<?php
namespace Shop\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Admin\View\Helper\FuncHelper;

class ExportpdfCell extends Cell
{
    public function display($token = null) {
        
        $order = TableRegistry::get('Shop.ShopOrders')->find('all')
            ->where(['trackcode'=>$token])
            ->contain([
                'Users',
                'ShopOrdershippings',
                'ShopAddresses'=>['ShopUseraddresses'],
                'ShopOrderproducts'=>['ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']],
                'ShopOrdertexts'])
            ->first();
            
        $this->Func = new FuncHelper(new \Cake\View\View());
        $setting = $this->Func->OptionGet('plugin_shop');
        if(isset($setting['plugin_shop']))
            $setting = unserialize($setting['plugin_shop']);
        else{
            $setting = unserialize($setting);
        }
        $this->set([
            'setting' => $setting,
            'results' => $order
        ]);
    }
}