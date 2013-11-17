<?php
class Register_Validation_Controller{
	public function main($get_vars=array()){
		$session=new Session_Helper;
		$users=new Users_Model;
		$functions = new Functions_Helper;
		$form_registration_passed=false;
		//first check if the new_username is valid(not taken/long enough)
		if(isset($_REQUEST['new_username']) && $_REQUEST['new_username']!=""){
			$new_username= trim($_REQUEST['new_username']);
			$is_user_exists=$users->find_existed_username($new_username);
			if(!$is_user_exists){
				$form_registration_passed=true;
				if(strlen($_REQUEST['new_username'])<6 || strlen($_REQUEST['new_username'])>30){
					$form_registration_passed=false;
				echo '<p>*Username must be minimun 6 and maximun 30 characters</p>';
				}else{
				$form_registration_passed=true;
				}
			}else{
				$form_registration_passed=false;
				echo '<p>*This username has been taken.pleasr try another one</p>';
			}	
		}
		//check new_user_password
		if(isset($_REQUEST['new_user_password']) && $_REQUEST['new_user_password']!=""){
			if(strlen($_REQUEST['new_user_password'])<6 || strlen($_REQUEST['new_user_password'])>30){
				$form_registration_passed=false;
				echo '<p>*Password must be minimun 6 and maximun 30 characters</p>';
			}else{
				$form_registration_passed=true;
			}						
		}
		//now check new_user_email 
		if(isset($_REQUEST['new_user_email']) && $_REQUEST['new_user_email']!=""){
		    $new_user_email= trim($_REQUEST['new_user_email']);
		    //ckeck for a valid new_user_email here
		    $valid_email=$functions->valid_email($new_user_email);
        	if(!$valid_email){
				//new_user_email is valid
				$is_email_exists=$users->find_existed_email($new_user_email);
				if(!$is_email_exists){
					$form_registration_passed=true;
				}else{
					$form_registration_passed=false;
					echo '<p>This email has been registered before.pleasr try another one</p>';
				}	
			}else{
				$form_registration_passed=false;
				echo '<p>*This is not a valid email</p>';
			}	
		}
		if(isset($_REQUEST['name'])) {
			if($_POST['name']!=""){
				echo '<p>Sorry.Your registeration has not accepted.Please fill the fields properly and try again.</p>';
				$form_registration_passed=false;
			}
		}
		if(! isset($_REQUEST['signup_checkbox']) && isset($_REQUEST['new_username']) && isset($_REQUEST['new_user_password']) && isset($_REQUEST['new_user_email'])) {
			$form_registration_passed=false;
			echo '<p>Please check the checkbox to confirm you are not a robot to successfully signup.</p>';
		}
		if($form_registration_passed &&  $_REQUEST['name']=="" && isset($_POST['new_username']) &&  $_REQUEST['new_username']!="" && isset($_POST['new_user_password']) && $_REQUEST['new_user_password']!="" && isset($_POST['new_user_email']) && $_REQUEST['new_user_email']!="" && isset($_REQUEST['signup_checkbox'])){
			$new_user=new Users_Model;
			$new_user->username=$username= trim(filter_input(INPUT_POST, 'new_username', FILTER_SANITIZE_SPECIAL_CHARS));
			$new_user->password=$password=trim(filter_input(INPUT_POST, 'new_user_password', FILTER_SANITIZE_SPECIAL_CHARS));
			$new_user->email=$email= trim(filter_input(INPUT_POST, 'new_user_email', FILTER_SANITIZE_SPECIAL_CHARS));
		   	$new_user->security_id=$security_id=md5(uniqid(rand()));
	    	$new_user->date_created=$date_created=strftime("%Y-%m-%d %H:%M:%S", time());
	    	$is_user_exists=$new_user->find_existed_username($username);
		   	$is_new_user_email_exists=$new_user->find_existed_email($email);	    	  
	 	    //if this new_username/new_user_email does not exist in the database
    	 	if(!$is_user_exists && !$is_email_exists){
	    	    //now create the row of new user in the database
		    	$user_created=$new_user->create();
			  	$find_created_user=$new_user->find_by_user_id($new_user->user_id);
				//if user created then send the new_user_email			
		       	$mail=new PHPMailer_Mailer();
		       	$mail->SMTPDebug = 1;
		    	$mail->IsSMTP();  // telling the mailer class to use SMTP
				$mail->WordWrap = 50;
				$mail->From = "admin@sky4life.com";
		        $mail->FromName="Sky4life Admin";
				$mail->AddAddress($email,$username); 
				$mail->Subject  = "Sky4life Registration Confirmation";
				$mail->IsHTML(true);		   
				// message body for the unique user that already been created   
				$mail->Body="<p style='border:thin solid black;padding:2em 1em;font-size:1.2em;border-radius: 15px;background: rgb(130,170,200);letter-spacing: .03em;line-height: 1.5em;'>Dear <b style='font-size: 1.3em;color: rgb(230,0,0);'>$find_created_user->username</b>,<br/><br/> 
			    The link below,is your activation link to join our website. In order to confirm your membership,please click on it:<br/>
			    <a href='http://www.sky4life.com/profile/$find_created_user->user_id/$find_created_user->security_id'>Registration link.</a><br/><br/>
			    Thank you</p>";			 
				$mail->Send();
				if($mail->Send()){
					//we show the good guy only in one case and the bad one for the rest.
					echo  '<p class="confirmation-message">*Account created.The confirmation link has been sent to your email.Click on it and its all done.Thanks.</p>';
				    $_POST['new_user_password']=$_POST['new_user_email']=$_POST['new_username']="";
				}else { 
					echo  '<p>*Failed sending the validation email out.Please try again.</p>';
				}
		    }
		         
        }
    }
}