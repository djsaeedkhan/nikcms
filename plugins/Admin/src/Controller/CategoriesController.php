<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

class CategoriesController extends AppController
{
    public function initialize(){
        parent::initialize();
    }

    public function index(){
        $cat = $this->Categories->newEntity();
        try {
             $this->Categories->recover();
        } catch (\Exception $e) {}
        
       
        $parentCategory = $this->Categories
            ->find('treeList',['keyField'=>'id','valueField'=>'title','spacer' => '—'])
            ->where(['post_type'=>$this->post_type]);

        $categories = $this->paginate(
            $this->Categories->find('treeList',['spacer' => '—'])
                ->contain(['Posts'])
                ->order(['lft'=>'asc'])
                ->where(['post_type'=>$this->post_type])
            ,['limit' => 200]);

        $this->set(compact('cat','categories','parentCategory'));
    }

    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Posts']
        ]);
        $this->set('category', $category);
    }

    public function add($id = null)
    {
        if($id != null)
            $category = $this->Categories->get(intval($id), ['contain' => ['CategorieMetas']]);
        else
            $category = $this->Categories->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            //$this->request->data['post_type'] = $this->post_type;
            $this->request = $this->request->withData('slug', strtolower($this->request->getData()['slug']) );

            if($this->request->getData()['parent_id'] == null)
                $this->request = $this->request->withData('parent_id', 0 );

            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($result = $this->Categories->save($category)) {

                if(($this->request->getData('CategorieMetas'))):
                foreach($this->request->getData('CategorieMetas') as $key => $val){
                    $this->Func->PostMetaSave($result->id,[
                        'source' =>'category',
                        'type' => 'meta',
                        'name' => $key,
                        'value' => $val,
                        'action' => 'create']);
                }
                endif;
                
                $this->Flash->success(__d('Admin', 'ثبت دسته بندی با موفقیت انجام شد'));
                if($id != null){
                    return $this->redirect($this->referer());
                }
                else
                    return $this->redirect($this->referer().'&cur='.$category['parent_id']);
            }
            $this->Flash->error(__d('Admin', 'متاسفانه ثبت دسته بندی انجام نشد'));
        }
        $posts = $this->Categories->Posts->find('list', ['limit' => 200]);
        $parentCategory = $this->Categories
            ->find('treeList',['keyField'=>'id','valueField'=>'title'])
            ->where(['post_type' => $category['post_type']]);

        $post_meta_list=array();
        if(isset($category->categorie_metas))
            $post_meta_list = $this->Func->MetaList($category,'category');

        $this->set(compact('category', 'posts','parentCategory','post_meta_list'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__d('Admin', 'حذف دسته بندی با موفقیت انجام شد'));
        } else {
            $this->Flash->error(__d('Admin', 'متاسفانه حذف دسته بندی انجام نشد'));
        }
        //['action' => 'index','?'=>['post_type'=>$category['post_type']]]
        return $this->redirect($this->referer());
    }
}
