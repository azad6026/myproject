<?php
	class Confirm_Password_Reset_Controller
{
	public $template = 'confirm_password_reset';
	
	public function main($get_vars=array())
	{
		$session=new Session_Helper;
		$functions = new Functions_Helper;
    	$user_model= new Users_Model;
    	$confirm_password_reset = new View_Model('confirm_password_reset');
    	global $message;
    	//examine and prepare id and security_id for confirmatio 
    	$user_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;
        $security_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;
	    
		$already_user=$user_model->find_registered_user($user_id,$security_id);
		$_SESSION['username']=$username=$already_user->username;
	    $_SESSION['user_id']=$user_id=$already_user->user_id;
		
		if($already_user)
		{
			$message= 'Welcome  '.$already_user->username.'<br/>You can set and change your new password here now.<br/><br/>';
		}
		else {
		
			$message = 'User not found !';
		
		}

		$confirm_password_reset->data['blank_fields']=$message;

		$nav= new View_Model('nav');
		if($session->is_logged_in()) {
        $nav->data['welcome_user']=true;
		} 
		 else {
        $nav->data['welcome_user']=false;
		} 


		$head= new View_Model('head');
		$logo= new View_Model('logo');		
		$main_content = new View_Model('main_content');
		$main_content->data['main_header']=false;
		$main_content->data['main1']=false;
		$main_content->data['main2']=$confirm_password_reset->render(false);
		$footer = new View_Model('footer');
		$master = new View_Model('master');
		$master->data['head']=$head->render(false);
		$master->data['logo']=$logo->render(false);
		$master->data['nav']=$nav->render(false);
		$master->data['footer']="";
		$master->data['main']=$main_content->render(false);
		$master->render();
		
	}
}
		