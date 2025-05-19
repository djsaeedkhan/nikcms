<?php
namespace Shop\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Shop\View\Helper\ShopHelper;

class ProductCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize(){
        $this->Sparams = TableRegistry::get('Shop.ShopProductParams');
        $this->Sattrs = TableRegistry::get('Shop.ShopAttributes');
        $this->majors = TableRegistry::get('Shop.ShopProductmajors');
        $this->ShopMetas = TableRegistry::get('Shop.ShopProductMetas');
        $this->Posts = TableRegistry::get('Admin.Posts');
        $this->PDetail = TableRegistry::get('Shop.ShopProductdetails');
        $this->PPrice = TableRegistry::get('Shop.shopProductprices');
        $this->Stock = TableRegistry::get('Shop.shopProductstocks');
    }

    public function display() {
        global $post_id;
        global $product_data;
        $data = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put']) and isset($data['ShopMetas']) ) {
            
            if(isset($data['ShopMetas'])){
                $this->ShopMetas->deleteAll(['post_id' => $post_id]);
                foreach($data['ShopMetas'] as $list=>$value){
                    $temp = $this->ShopMetas->newEntity();
                    $temp = $this->ShopMetas->patchEntity($temp,[
                        'post_id' => $post_id,
                        'meta_key' => $list,
                        //'meta_value' => is_array($value)?serialize($value): $value
                        'meta_value' => is_array($value)?implode(';',$value): $value
                        ]);
                    $this->ShopMetas->save($temp);
                }
            }
            
            $this->PDetail->deleteAll(['post_id' => $post_id]);
            if(isset($data['Meta'])){
                foreach($data['Meta'] as $list => $value){
                    $temp = $this->PDetail->newEntity();
                    $temp = $this->PDetail->patchEntity($temp,[
                        'post_id' => $post_id,
                        'pattern' => $list,
                        'image' => $value['image'],
                        'sku' => $value['sku'],
                        'price' => $value['price'],
                        'stock' => null,
                        'disable' => isset($value['disable'])?$value['disable']:0,
                        'descr' => isset($value['description'])?$value['description']:null,
                        ]);
                    $this->PDetail->save($temp);
                }
            }

            if(isset($data['shop']['params']['list']) and count($data['shop']['params']['list'])){
                $this->Sparams->deleteAll(['post_id' => $post_id]);
                foreach($data['shop']['params']['list'] as $list => $value){
                    $temp = $this->Sparams->newEntity();
                    $temp = $this->Sparams->patchEntity($temp,[
                        //'id'=> (array_search($list, $param_list)?array_search($list, $param_list): false),
                        'post_id' => $post_id,
                        'shop_param_id' => $list,
                        'value' => $value ]);
                    $this->Sparams->save($temp);
                }
            }
            
            //Save Stocks
            $this->Stock->deleteAll(['post_id' => $post_id]);
            if( isset($data['ShopMetas']['stock']) ){
                $temp = $this->Stock->newEntity();
                $temp = $this->Stock->patchEntity($temp,[
                    'post_id' => $post_id,
                    'pattern' => null,
                    'stock' => $data['ShopMetas']['stock'] ]);
                $this->Stock->save($temp);
            }
            if(isset($data['Meta'])){
                foreach($data['Meta'] as $list => $value){
                    $temp = $this->Stock->newEntity();
                    $temp = $this->Stock->patchEntity($temp,[
                        'post_id' => $post_id,
                        'pattern' => $list,
                        'stock' => isset($value['stock'])?$value['stock']:null, ]);
                    $this->Stock->save($temp);
                }
            }

            $this->majors->deleteAll(['post_id' => $post_id,'pattern IS NOT NULL']);
            if($data['ShopMetas']['product_type'] == 'wholesale' and isset($data['big_price'])){
                if($data['ShopMetas']['product_type'] == 'wholesale'){
                    foreach($data['big_price'] as $value){
                        if( isset($value['start']) and $value['start'] != ''):
                            $temp = $this->majors->newEntity();
                            $temp = $this->majors->patchEntity($temp,[
                                'post_id' => $post_id,
                                'start' => $value['start'],
                                'pattern' => isset($value['pattern'])?$value['pattern']:null,
                                'price' => $value['price'] ]);
                            $this->majors->save($temp);
                        endif;
                    }
                }  
            }

            if($data['ShopMetas']['product_type'] == 'wholesale' and isset($data['big_price2'])){
                $this->majors->deleteAll(['post_id' => $post_id,'pattern IS NULL']);
                if($data['ShopMetas']['product_type'] == 'wholesale'){
                    foreach($data['big_price2'] as $value){
                        if( isset($value['start']) and $value['start'] != ''):
                            $temp = $this->majors->newEntity();
                            $temp = $this->majors->patchEntity($temp,[
                                'post_id' => $post_id,
                                'start' => $value['start'],
                                'price' => $value['price'] ]);
                            $this->majors->save($temp);
                        endif;
                    }
                }  
            }

            //Save Other price chart
            $first_price = ShopHelper::PriceGet($post_id);
            $price = explode(' - ',$first_price);
            $price = preg_replace('/[^0-9]/', '',isset($price[0])?$price[0]:$first_price );
            $find = $this->PPrice->find('all')
                ->where(['post_id'=> $post_id , 'created = '=> date('Y-m-d')])
                ->first();
            $temp = $this->PPrice->newEntity();
            $temp = $this->PPrice->patchEntity($temp ,[
                'id' => isset($find['id'])?$find['id']:null,
                'post_id' => $post_id,
                'price' => $price,
                'created' => date('Y-m-d'),
            ]);
            $this->PPrice->save($temp);
        }
        
        $product_data['param_list'] = $this->Sparams->find('list',['keyField'=>'shop_param_id','valueField'=>'value'])
            ->where(['post_id'=>$post_id])
            ->toarray();

        $product_data['major_list'] = $this->majors->find('all')->where(['post_id'=>$post_id])
            ->toarray();
        
        $product_data['shop_metas'] = $this->ShopMetas->find('list',['keyField'=>'meta_key','valueField'=>'meta_value'])
            ->where(['post_id'=>$post_id])
            ->toarray();

        $product_data['product_list'] = $this->Posts->find('list',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type'=>'product'])
            //->order(['posts.id'=>'desc'])
            ->toarray();

        $product_data['product_detail'] = $this->PDetail->find('all')
            ->where(['post_id'=> $post_id])
            ->toarray();    

        $product_data['attr_list'] = $this->Sattrs->find('list',['keyField'=>'id','valueField'=>'title'])
            ->toarray();

        $product_data['stocks'] = $this->Stock->find('list',['keyField'=>'pattern','valueField'=>'stock'])
            ->where(['post_id'=> $post_id])
            ->toarray();
    }
}