<?php
class Login_Validation_Controller
{
	public function main($get_vars=array()){
		$session=new Session_Helper; 
		$functions = new Functions_Helper;
		$users=new Users_Model;
		if(isset($_REQUEST['username']) && $_REQUEST['username']!=""){
			$username= trim($_REQUEST['username']);
			$is_user_exists=$users->find_existed_username($username);
			if(!$is_user_exists){
				echo '<p>*Username is not valid.</p>';		
			}
		}	
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
						echo '<p>*Dear user,Your membership is not active.Please open the email we have sent and click on the activation link.Thanks</p>';
					}else{
								echo '<p>*Redirecting</p>';
								$session->login($activated_user);
							    //$functions->redirect_to("/posts");
						}
					}else{
					echo '<p>*This username/password combination was not found.please try again</p>';
				}
	       }else{
	       	    //echo 'Please fill both your username and password to access your account';
	       }		
		}			
	}		 
}