<?php
namespace Template\View\Cell;
use Cake\View\Cell;
class MetaCell extends Cell{
    protected $_validCellOptions = [];
    public function initialize(): void
    {}
    public function data($posttype = null, $post_meta_list = null){
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
	/* public function collections($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    } */
    /* public function initiatives($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function locations_cat($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }

    public function awards($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    } */
    
    public function page($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
}