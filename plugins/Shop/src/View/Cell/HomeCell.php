<?php
namespace Shop\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class HomeCell extends Cell
{
    public function dashboard(){

        $sum = TableRegistry::get('Shop.ShopPayments')->find('all')->where(['paid'=>1]);
        $sum = $sum->select(['sum' => $sum->func()->sum('ShopPayments.price')])->first();

        $view = TableRegistry::get('Admin.PostMetas')->find('all');
        $view = $view
            ->where([ 'meta_key'=>'post_views','post_id IN'=> TableRegistry::get('Admin.Posts')->find('list',['keyField'=>'id','valueField'=>'id'])->where(['post_type'=>'product'])->toarray()])
            ->select(['sum' => $view->func()->sum('PostMetas.meta_value')])->first();

        $this->set([
            'product_all' => TableRegistry::get('Admin.Posts')->find('all')->where(['post_type'=>'product'])->count(),
            'order_all'=> TableRegistry::get('Shop.ShopOrders')->find('all')->count(),
            'price_all'=> isset($sum['sum'])? ($sum['sum'] / 10):0 ,
            'view_all'=> isset($view['sum'])? $view['sum']:0 ,
            /* 'personlike' => TableRegistry::get('Template.TmpPersonlikes')->find('all')->count(),
            'persons' => TableRegistry::get('Template.TmpPersons')->find('all')->count(),
            'persons_today' => TableRegistry::get('Template.TmpPersons')->find('all')->where(['DATE(TmpPersons.created)' => date('Y-m-d')])->count(),
            'problems' => TableRegistry::get('Template.TmpProblems')->find('all')->count(),
            'problems_today' => TableRegistry::get('Template.TmpProblems')->find('all')->where(['DATE(TmpProblems.created)' => date('Y-m-d')])->count(),
            'problemforms' => TableRegistry::get('Template.TmpProblemforms')->find('all')->count(),
            'user_all' => TableRegistry::get('Users')->find('all')->count(), */
        ]);
    }
}