<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = strip_tags($message,'<a><br>');
}
?>
<div class="alert alert-success" id="alert-success" style="font-size:14px;margin-top:20px;" ><?= $message ?>
    <span style="float: left;cursor:pointer" title="بستن">X</span>
</div>
<script nonce="<?=get_nonce?>">$("#alert-success span").click(function(){ $(this).parent().hide() });</script>