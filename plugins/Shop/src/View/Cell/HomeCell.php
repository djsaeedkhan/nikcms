<?php
namespace Shop\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class HomeCell extends Cell
{
    public function dashboard(){

        $sum = $this->getTableLocator()->get('Shop.ShopPayments')->find('all')->where(['paid'=>1]);
        $sum = $sum->select(['sum' => $sum->func()->sum('ShopPayments.price')])->first();

        $view = $this->getTableLocator()->get('Admin.PostMetas')->find('all');
        $view = $view
            ->where([ 'meta_key'=>'post_views','post_id IN'=> $this->getTableLocator()->get('Admin.Posts')->find('list',['keyField'=>'id','valueField'=>'id'])->where(['post_type'=>'product'])->toarray()])
            ->select(['sum' => $view->func()->sum('PostMetas.meta_value')])->first();

        $this->set([
            'product_all' => $this->getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type'=>'product'])->count(),
            'order_all'=> $this->getTableLocator()->get('Shop.ShopOrders')->find('all')->count(),
            'price_all'=> isset($sum['sum'])? ($sum['sum'] / 10):0 ,
            'view_all'=> isset($view['sum'])? $view['sum']:0 ,
            /* 'personlike' => $this->getTableLocator()->get('Template.TmpPersonlikes')->find('all')->count(),
            'persons' => $this->getTableLocator()->get('Template.TmpPersons')->find('all')->count(),
            'persons_today' => $this->getTableLocator()->get('Template.TmpPersons')->find('all')->where(['DATE(TmpPersons.created)' => date('Y-m-d')])->count(),
            'problems' => $this->getTableLocator()->get('Template.TmpProblems')->find('all')->count(),
            'problems_today' => $this->getTableLocator()->get('Template.TmpProblems')->find('all')->where(['DATE(TmpProblems.created)' => date('Y-m-d')])->count(),
            'problemforms' => $this->getTableLocator()->get('Template.TmpProblemforms')->find('all')->count(),
            'user_all' => $this->getTableLocator()->get('Users')->find('all')->count(), */
        ]);
    }
}