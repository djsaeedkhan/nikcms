<?php 
$enable = 0;
if($result['login_mode'] == 1){ // Redirecting to login
	if(! $this->request->getAttribute('identity')->get('id') ){
		header("Location: ".\Cake\Routing\Router::url(['controller' => 'Users', 'action' => 'Login']));
		die();
	}
	else
		$enable = 1;
}
if($result['member_mode'] == 1){ //Show site when logged in
	if( $this->request->getAttribute('identity')->get('id') )
		$enable = 1;
}
if($enable == 0){
	echo $result['display_text'];
	exit();
}