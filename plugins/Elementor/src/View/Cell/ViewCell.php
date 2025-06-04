<?php
namespace Elementor\View\Cell;

use Cake\View\Cell;

/**
 * View cell
 */
class ViewCell extends Cell
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
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($post_meta = []){
        global $post_id;

        if(isset($post_meta['elementor']) and $post_meta['elementor'] != '')
            $elements = $post_meta['elementor'];
        else
            $elements = [];

        if($elements == null)
            return $this->response->withStringBody("Element Not Found");

        $this->set([
            'post_meta' => $post_meta,
            'elements'=> $elements
        ]);
    }
}
