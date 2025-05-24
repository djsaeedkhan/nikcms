<?php
namespace Shop\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

class Exportpdf2Cell extends Cell
{
    public function display($token = null) {
        if(!is_array($token)){
            $token = [ $token => $token];
        }

        $order = $this->getTableLocator()->get('Shop.ShopOrders')->find('all')
            ->where(['trackcode IN '=>$token])
            ->contain([
                'Users','ShopOrdershippings',
                'ShopAddresses'=>['ShopUseraddresses'],
                'ShopOrderproducts'=>['Posts'=>'ShopProductMetas','ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']],
                'ShopOrdertexts'])
            ->toarray();

        $setting = $this->Func->OptionGet('plugin_shop');
        if($setting['plugin_shop'])
            $setting = unserialize($setting['plugin_shop']);

        $this->set([
            'setting' => $setting,
            'resultss' => $order
        ]);
    }
}