<?php 
$this->Func->getSiteSetting();
global $post_type;
global $maxrow;
$maxrow = 10;
$menu = [
    'report'=>[
        'title'=>'آمار',
        'sublevel'=> include_once('_reports.php'),
    ],
];
echo $this->cell('Admin.Formplus',[$menu,$post_meta_list]);
?>