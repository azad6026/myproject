<?php
class Change_Password_Validation_Controller
{

	
	public function main($get_vars=array())
	{
		$session=new Session_Helper;
		$users=new Users_Model;
		$functions = new Functions_Helper;
		$form_registration_passed=false;
		$user_id=$_SESSION['user_id'];
		$username=$_SESSION['username'];
		//check password
		if(isset($_REQUEST['password']) && $_REQUEST['password']!=""){
			if(strlen($_REQUEST['password'])<5 || strlen($_REQUEST['password'])>30){
				$form_registration_passed=false;
				echo 'password must be minimun 5 and maximun 30 and  characters';
			}			
			else {
				$password=trim($_REQUEST['password']);
				$changed_pass=$users->update_password($user_id,$password);
				if($changed_pass){
				    echo 'Your password has changed.You have logged in.Enjoy';

				}
				
			}
		
	    }

    }
}

	
		
		