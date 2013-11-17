<?php
class Reset_Password_Controller{
	public function main($get_vars=array()){
    	$session=new Session_Helper; 
    	$functions = new Functions_Helper;
    	$users=new Users_Model;	
    	$form_registration_passed=false;
        if(isset($_REQUEST['reset_password_email'])){
			$email= trim($_REQUEST['reset_password_email']);
			if($_POST['reset_password_email']!=''){
				$valid_email=$functions->valid_email($email);
                if(!$valid_email){
	   				$is_email_exists=$users->find_existed_email($email);
	                if($is_email_exists){
					    //email is valid
					    $form_registration_passed=true;
			            $mail=new PHPMailer_Mailer();
       		            $mail->SMTPDebug = 1;
    	                $mail->IsSMTP();  // telling the class to use SMTP
					    $mail->WordWrap = 50;
					    $mail->From = "admin@sky4life.com";
					    $mail->FromName="Sky4life Admin";
					    $mail->AddAddress($email,$username); 
					    $mail->Subject  = "Sky4life Reset Password";
					    $mail->IsHTML(true);	   				
			   	        // message body for the unique user that already been created 
					    $mail->Body="<p style='border:thin solid black;padding:2em 1em;font-size:1.2em;border-radius: 15px;background: rgb(130,170,200);letter-spacing: .03em;line-height: 1.5em;'>Dear <b style='font-size: 1.3em;color: rgb(230,0,0);'>$username</b>,<br/><br/> 
					    The link below,is your link to reset your password.You can change your password after reset it on your profile page:<br/><a href='http://www.sky4life.com/profile/$is_email_exists->user_id/$is_email_exists->security_id'>Reset password.</a><br/><br/>
					    Thank you</p>";
			            $mail->Send();
				   		if($mail->Send()){
					        //we show the good guy only in one case and the bad one for the rest.
							echo  '<p class="created-account-message">We sent password reset email.Please login to the email you provided and reset your password.</p>';
	                    	$_POST['password']=$_POST['email']=$_POST['username']=$_POST['reapeted_password']="";
					    }else{ 
							echo  '<p class="message">Failed sending the email out.Please try again.</p>';
				        }
                    }else{
						echo  '<p>this is not the email you used to register in our site.please try another one.thanks,/p>';
				    }
			    }else{
					echo  '<p>this is not a valid email.</p>';
			    }
			}else{
				echo  '<p>please enter your email.</p>';
			}
			
			
		}	
	}
    	
}