<?php
namespace Lms\View\Cell;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
class HomeCell extends Cell
{
    public function user_dashboard(){
        
        $lmsCourses = $lmsCoursefilecan = $lmsCoursefiles = $lmsCourseexam = [];
        try {
            $user_id = $this->request->getAttribute('identity')->get('id');
            $lmsCourses = TableRegistry::getTableLocator()->get('Lms.LmsCourseusers')->find('all')
                ->where(['LmsCourseusers.user_id'=> $user_id ])
                ->contain(['LmsCourses'=>['LmsCourseweeks'=>['LmsCoursefiles']]])
                ->order(['LmsCourseusers.id'=>'desc'])
                ->toarray();

            $lmsCoursefiles = [];
            $lmsCoursefilecan = [];
            $lmsCourseexam = [];

            foreach($lmsCourses as $lms){ 
                if(isset($lms['LmsCourses']['id'])){
                    $lms_id = $lms['LmsCourses']['id'];
                    $lmsCoursefiles[  $lms_id ] =  TableRegistry::getTableLocator()->get('Lms.LmsCoursefiles')
                        ->find('list',['keyField' => 'id','valueField' => 'id'])
                        ->where(['lms_course_id'=>  $lms_id ])
                        ->toarray();

                    if(isset($lmsCoursefiles[  $lms_id ]) and count($lmsCoursefiles[  $lms_id ])){
                        $query = TableRegistry::getTableLocator()->get('Lms.LmsCoursefilecans')
                            ->find('list',['keyField' => 'lms_coursefile_id','valueField' => 'count'])
                            ->select(['lms_coursefile_id','user_id'])
                            ->where(['user_id'=> $user_id , 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                            ->group(['lms_coursefile_id']);
                        $lmsCoursefilecan[  $lms_id ] =  $query->select(['count' => $query->func()->count('lms_coursefile_id') ])->toarray();

                        $lmsCourseexam[  $lms_id ]  = TableRegistry::getTableLocator()->get('Lms.LmsCourseexams')
                            ->find('list',['keyField' => 'id','valueField' => 'id'])
                            ->where([ 'lms_coursefile_id IN ' => $lmsCoursefiles[  $lms_id ]])
                            ->toarray();
                    }
                }
                
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        $this->set([
            'lmsCourses' => $lmsCourses,
            'lmsCoursefilecan' => $lmsCoursefilecan,
            'lmsCoursefiles'=> $lmsCoursefiles,
            'lmsCourseexam' => $lmsCourseexam,
        ]);
        /* 
        $sum = TableRegistry::getTableLocator()->get('Shop.ShopOrderproducts')->find('all');
        $sum = $sum->select(['sum' => $sum->func()->sum('ShopOrderproducts.subtotal')])->first();

        $view = TableRegistry::getTableLocator()->get('Admin.PostMetas')->find('all');
        $view = $view
            ->where([ 'meta_key'=>'post_views','post_id IN'=> TableRegistry::getTableLocator()->get('Admin.Posts')->find('list',['keyField'=>'id','valueField'=>'id'])->where(['post_type'=>'product'])->toarray()])
            ->select(['sum' => $view->func()->sum('PostMetas.meta_value')])->first();

        $this->set([
            'product_all' => TableRegistry::getTableLocator()->get('Admin.Posts')->find('all')->where(['post_type'=>'product'])->count(),
            'order_all'=> TableRegistry::getTableLocator()->get('Shop.ShopOrders')->find('all')->count(),
            'price_all'=> isset($sum['sum'])? $sum['sum']:0 ,
            'view_all'=> isset($view['sum'])? $view['sum']:0 ,

            'personlike' => TableRegistry::getTableLocator()->get('Template.TmpPersonlikes')->find('all')->count(),
            'persons' => TableRegistry::getTableLocator()->get('Template.TmpPersons')->find('all')->count(),
            'persons_today' => TableRegistry::getTableLocator()->get('Template.TmpPersons')->find('all')->where(['DATE(TmpPersons.created)' => date('Y-m-d')])->count(),
            'problems' => TableRegistry::getTableLocator()->get('Template.TmpProblems')->find('all')->count(),
            'problems_today' => TableRegistry::getTableLocator()->get('Template.TmpProblems')->find('all')->where(['DATE(TmpProblems.created)' => date('Y-m-d')])->count(),
            'problemforms' => TableRegistry::getTableLocator()->get('Template.TmpProblemforms')->find('all')->count(),
            'user_all' => TableRegistry::getTableLocator()->get('Users')->find('all')->count(),
        ]); */
    }
}