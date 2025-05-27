<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = strip_tags($message,'<a><br>');
}
?>
<div class="alert alert-warning" style="font-size:14px;margin-top:20px;" >
    <?= $message ?>
    <span style="float: left;cursor:pointer" id="alert-warning" title="بستن">X</span>
</div>
<script nonce="<?=get_nonce?>">$("#alert-warning span").click(function(){ $(this).parent().hide() });</script>