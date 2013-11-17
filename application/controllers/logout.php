<?php
class Logout_Controller{
	public function main($get_vars=array()){
		$session=new Session_Helper;
		$functions = new Functions_Helper;
		$session->logout();
		$functions->redirect_to("/");
	}
}
?>