<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = strip_tags($message,'<a><br>');
}
?>
<div class="alert alert-info" style="font-size:14px;margin-top:20px;" ><?= $message ?>
<span style="float: left;cursor:pointer" title="بستن">X</span></div>