<?php
use Cake\View\Cell;
try {
echo $this->cell('Template.Error404');
} catch (\Exception $e){
    return $this->render('404');
}
?>
<!-- <h2>Page not found</h2>error09 -->