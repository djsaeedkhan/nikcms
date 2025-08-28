<?php
use Admin\View\Helper\QueryHelper;
use Cake\Routing\Router;
use Cake\View\Helper\FormHelper;
use Challenge\Predata;
$predata = new Predata();
try {
    echo $this->element('Challenge.ch_modal');
} catch (\Throwable $th) {
    //throw $th;
}
?>

<?= $this->cell('Challenge.Questions',[$ch_id]);?>