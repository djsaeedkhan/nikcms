<?php
namespace Shop\View\Cell;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

class CronjobsCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function display(){
        $sdate = Time::now();
        $sdate->modify('-1 hours');
        $edate = new \DateTime();
        $this->ShopOrders = TableRegistry::get('Shop.ShopOrders');

        $query = $this->ShopOrders->find()
            ->where([
                'status'=>'pending',
                'enable' => 1,
                function ($exp, $q) use ($sdate, $edate) {
                $between = clone $exp;
                return  $exp->not($between->between('created', $sdate, $edate));
            }])
            //->limit(1)
            ->toarray();

        foreach($query as $q){
            $shopOrder = $this->ShopOrders->get($q['id']);
            if($shopOrder){
                $id = $shopOrder['id'];
                foreach(TableRegistry::get('Shop.ShopOrderproducts')->find('all')->where(['shop_order_id' => $id])->toarray() as $tmp ){
                    TableRegistry::get('Shop.ShopOrderattributes')->deleteAll(['shop_orderproduct_id' => $tmp['id'] ]);
                }
                TableRegistry::get('Shop.ShopOrderproducts')->deleteAll(['shop_order_id' => $id ]);
                TableRegistry::get('Shop.ShopOrdertokens')->deleteAll(['shop_order_id' => $id ]);
                TableRegistry::get('Shop.ShopOrdertexts')->deleteAll(['shop_order_id' => $id ]);
                TableRegistry::get('Shop.ShopOrdershippings')->deleteAll(['shop_order_id' => $id ]);
                TableRegistry::get('Shop.ShopPayments')->deleteAll(['shop_order_id' => $id ]);
            }
            if($this->ShopOrders->delete($shopOrder))
                echo "order ". $id ." Deleted<br>";
            else
                echo "Err: order ". $id ." NotDeleted<br>";
        }
    }
}
