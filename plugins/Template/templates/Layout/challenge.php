<?php
if(isset($challenge->password) and $challenge->password != '' and $can_password == false):
	include_once('challenge-pass.php');
else:
	include_once('challenge-nopass.php');
endif;?>