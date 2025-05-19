<?php
namespace Shop\View\Cell;
use Cake\View\Cell;
class FormDetailCell extends Cell
{
    protected $_validCellOptions = [];
    public function initialize() {}
    public function display($pattern= null, $data = null, $product_data = null){
        $this->set([
            'pattern'=> $pattern,
            'data' => $data,
            'product_data' => $product_data ]);
    }
}