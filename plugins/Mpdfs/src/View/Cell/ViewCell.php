<?php
namespace Mpdf\View\Cell;
use Cake\View\Cell;
class ViewCell extends Cell {
    protected $_validCellOptions = [];
    public function initialize(): void
    {
        parent::initialize();
    }
    public function display(){}
}