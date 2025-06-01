<?php
namespace Template\View\Cell;
use Cake\View\Cell;
class MetaCell extends Cell{
    protected $_validCellOptions = [];
    
    public function knowledge($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
    public function sources($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function multimedia($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function organizations($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
    
    public function topics($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function models($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function dashboard($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

	public function impacts($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
	
    public function page($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
}