<style>
.content-header-title1{display:none}
<?php if(isset($current) and $current =="index"):?>
.profile-section-header{
	float: right;
}
.table-responsive{
	display: contents;
}
.btn.btn-sm.btn-primary.mx-1{
	margin-top: 5px;
}
<?php endif;?>
.table-responsive table{
	font-size: 14px !important;
}
#plugin_ticket_my_comment .title{
	display:none;
}
</style>
<?php include_once("profile.php");?>
