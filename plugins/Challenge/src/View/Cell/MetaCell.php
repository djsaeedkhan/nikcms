<?php
namespace Challenge\View\Cell;
use Cake\View\Cell;
class MetaCell extends Cell{
    public function chnews($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
    public function chresource($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
    public function chupdates($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
}