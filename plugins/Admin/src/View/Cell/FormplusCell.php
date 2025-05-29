<?php
namespace Admin\View\Cell;

use Cake\View\Cell;

/**
 * Formplus cell
 */
class FormplusCell extends Cell
{
    /**
     * Default display method.
     *
     * @return void
     */
    public function display($menu = null,$post_meta_list = null){
        $this->set([
            'menu'=>$menu,
            'post_meta_list'=>$post_meta_list
        ]);
    }
}
