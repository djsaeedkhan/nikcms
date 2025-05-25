<?php
namespace Template\View\Cell;
use Cake\View\Cell;
class MetaCell extends Cell{
    protected $_validCellOptions = [];
    public function initialize(): void
    {}
    public function product($posttype = null, $post_meta_list = null){
        $this->set([
            'post_meta_list' =>$post_meta_list,
            'posttype'=>$posttype,
        ]);
    }
}