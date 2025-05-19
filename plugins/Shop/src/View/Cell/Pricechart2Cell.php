<?php
namespace Shop\View\Cell;
use Admin\View\Helper\FuncHelper;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class Pricechart2Cell extends Cell{
    public function display($id = null){
        global $is_status;
        if($is_status == 'single'){
            global $result;
            $this->Func = new FuncHelper(new \Cake\View\View());
            
            $data = [];
            if(isset($result['id'])){
                $temps = TableRegistry::get('Shop.ShopProductprices')->find('all')
                    ->where(['post_id'=> $result['id'] ])
                    ->limit(30)
                    ->order(['created'=> 'asc'])
                    ->toArray();

                foreach($temps as $temp){
                    $data[0][] = $temp['price'];
                    $data[1][] = '"'.$this->Func->mil_to_shm($temp['created']->format('Y-m-d'),'-').'"';
                }
            }
            $this->set(['data'=> $data]);
        }
    }
}