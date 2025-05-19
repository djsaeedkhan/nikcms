<?php
namespace Shop\Controller;

use Shop\Controller\AppController;
use Cake\ORM\TableRegistry;

class ReportController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->ViewBuilder()->setLayout('Admin.default');
    }
    //-----------------------------------------------------------
    public function index(){
        switch (strtolower($this->request->getQuery('action'))) {
            case 'stocks':  return $this->_stocks();break;
            case 'sell':    return $this->_sell();break;
            case 'exit':    return $this->_exitorder();break;
            case 'daily':  return $this->_daily();break;
            case 'monthly': return $this->_monthly();break;
            case 'year': return $this->_year();break;
            default:        return $this->_sell();break;
        }
    }
    //-----------------------------------------------------------
    private function _stocks(){
        $results = TableRegistry::get('Shop.Posts')->find('all')
            ->contain(['ShopProductstocks'])
            ->order(['Posts.id'=>'desc'])
            ->where(['post_type'=>'product'])
            ->toarray();
        $pattern = TableRegistry::get('Shop.ShopAttributelists')
            ->find('list',['keyField'=>'id','valueField'=>'title'])
            ->toarray();

        $this->set(compact('results','pattern'));
        $this->render('stocks');
    }
    //-----------------------------------------------------------
    private function _monthly(){
        $query = TableRegistry::get('Shop.ShopPayments')->find();
        $query = $query
            ->select([
                'count' => $query->func()->count('id'), 
                'price' => $query->func()->sum('price'), 
                'created',
                'month' => 'MONTH(created)'])
            ->group(['month' => 'MONTH(created)'])
            ->order(['ShopPayments.id'=>'desc'])
            ->where(['paid'=> 1])
            ->limit(1000)
            ->toarray();
        $this->set(['results'=>  $query]);
        $this->render('monthly');
    }
    //-----------------------------------------------------------
    private function _year(){
        $query = TableRegistry::get('Shop.ShopPayments')->find();
        $query = $query
            ->select([
                'count' => $query->func()->count('id'), 
                'price' => $query->func()->sum('price'), 
                'created',
                'year' => 'YEAR(created)'])
            ->group(['year' => 'YEAR(created)'])
            ->order(['ShopPayments.id'=>'desc'])
            ->where(['paid'=> 1])
            //->limit(100)
            ->toarray();
        $this->set(['results'=>  $query]);
        $this->render('year');
    }
    //-----------------------------------------------------------
    private function _daily(){
        $query = TableRegistry::get('Shop.ShopPayments')->find();
        $query = $query
            ->select([
                'count' => $query->func()->count('id'), 
                'price' => $query->func()->sum('price'), 
                'created',
                'day' => 'DAY(created)'])
            ->group(['day' => 'DAY(created)'])
            ->order(['ShopPayments.id'=>'desc'])
            ->where(['paid'=> 1])
            ->limit(500)
            ->toarray();
        $this->set(['results'=>  $query]);
        $this->render('day');
    }
    //-----------------------------------------------------------
    private function _exitorder(){
        $this->set(['results'=> 
            TableRegistry::get('Shop.ShopOrders')->find('all')
                ->contain([
                    'ShopAddresses'=>['ShopUseraddresses'],
                    'shopOrdershippings',
                    'ShopOrderproducts'=>['ShopOrderattributes'=>['ShopAttributes','ShopAttributelists']],
                    'ShopPayments'])
                ->order(['ShopOrders.id'=>'desc'])
                ->toarray()
        ]);
        $this->render('exit_order');
    }
    //-----------------------------------------------------------
    private function _sell(){
        $results = TableRegistry::get('Shop.ShopOrderproducts')->find();
        $results = $results
            ->select([
                'count' => $results->func()->count('post_id'), 
                'qty' => $results->func()->sum('quantity'), 
                'price' => $results->func()->sum('subtotal'), 
                'post_id','name','attrs'
                ])
            ->group(['post_id'])
            ->contain(['Posts'])
            ->order(['ShopOrderproducts.id'=>'desc'])
            //->where(['post_type'=>'product'])
            ->toarray();
        $this->set(['results'=> $results]);
        $this->render('sell');
    }    
    //-----------------------------------------------------------
}