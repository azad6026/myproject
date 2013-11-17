<?php
class Login_Controller
{
	public $template = 'login';	
	public function main($get_vars=array())
	{
    	$session=new Session_Helper; 
    	$functions = new Functions_Helper;

    	global $message;
    	$users=new Users_Model;
    	$form_registration_passed=false;		
		//to make sure that ther is no blank fields,check it inside this if and do not put it in this if
		if(isset($_POST['username'])  && isset($_POST['password'])){
			$username= trim($_POST['username']);
			$password= trim($_POST['password']);
			if($username!="" && $password!=""){
				$found_user=$users->authenticate($username,$password);
				if($found_user){
					$activated_user=$users->find_activated_username($username);
					if(!$activated_user ){
						//now log in your user
						$message= 'Dear user,You can not login.Your membership was not activated.Please open the email that we sent and click on the activation link';

					}else{
						echo 'You can login now.';
						$session->login($activated_user);

						$form_registration_passed=true;
					    $functions->redirect_to("/");
					}
				}else{
				$message= 'This username/password combination was not found.please try again';
			
			    }	
	       }else{
	       	    //echo 'Please fill both your username and password to access your account';
	       }
				
		}
    }
}