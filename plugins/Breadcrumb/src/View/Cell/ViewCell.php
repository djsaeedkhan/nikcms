<?php
namespace Breadcrumb\View\Cell;
use Cake\View\Cell;

class ViewCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize()
    {
    }
    public function display($split= null , $div = null,$options = [])
    {
        $split = ($split == null ?'<i class="fa fa-angle-double-left"></i>':$split);
        $div = ($div == null ?'span':$div);
        $temp = $temp2 = $post_type = null;
        $current = isset($options['current'])?$options['current']:1;
        $exclude = isset($options['exclude'])?$options['exclude']:[];

        $action = $this->request->getParam('action');
        switch ($action):
            case 'single':
                $id = $this->request->getParam('id');
                $this->loadModel('Admin.Posts');
		        $temp = $this->Posts->find('all')
                    ->where(['Posts.id' => $id ])
                    ->select(['id','title','slug','post_type'])
                    ->contain('Categories')
                    ->enablehydration(false)
                    ->first();
                $post_type = $this->request->getParam('posttype');
                break;
                
            case 'search':
                $temp = (isset($this->request->getParam('?')['s']) and $this->request->getParam('?')['s']!='')?
                    $this->request->getParam('?')['s']:'';
                $post_type = $this->request->getParam('posttype');
                break;

            case 'tag':
                $temp = $this->request->getParam('catid');
                $post_type = $this->request->getParam('posttype');
                break;

            case 'index':
                $temp = $this->request->getParam('catid');
                $temp2 = $this->request->getParam('catslug');
                $post_type = $this->request->getParam('posttype');
                break;
            
            case 'category':
                $temp = $this->request->getParam('catid');
                $temp2 = $this->request->getParam('catslug');
                $post_type = $this->request->getParam('posttype');
                break;
        endswitch;

        $this->set([
            'action' => $action,
            'temp' => $temp,
            'temp2' => $temp2,
            'post_type' => $post_type,
            'split' => $split,
            'div' => $div,
            'current' => $current,
            'options' => $options,
            'exclude'=>$exclude
        ]);
    }

}
