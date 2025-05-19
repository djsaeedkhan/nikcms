<?php
namespace Admin\View\Cell;

use Cake\View\Cell;

/**
 * Formplus cell
 */
class FormplusCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

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
