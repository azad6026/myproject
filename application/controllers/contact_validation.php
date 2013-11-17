<?php
class Contact_Validation_Controller
{
	public function main($get_vars=array())
	{
    	$session=new Session_Helper; 
    	$functions = new Functions_Helper;
    	$users=new Users_Model;
    	$form_registration_passed=false;
		if(isset($_REQUEST['contact_email']) ){
			$contact_email= trim($_REQUEST['contact_email']);
			$valid_email=$functions->valid_email($contact_email);
			if(!$valid_email){
			$form_registration_passed=true;
			}else{
			$form_registration_passed=false;
			echo '<p>This email is not valid.Please try again.</p>';
			}
		}
		if(isset($_REQUEST['name'])) {
			if($_POST['name']!=""){
				echo '<p>Sorry.Your message can not be send.Please fill the fields properly as form says.</p>';
				$form_registration_passed=false;
			}
		}
		if($_REQUEST['contact_content'] == "") {
				$form_registration_passed=false;
				echo '<p>Please write your message.</p>';
		}
		if(! isset($_REQUEST['contact_checkbox'])) {
				$form_registration_passed=false;
				echo '<p>To send the message,please check the checkbox to confirm that you are not a robot.Thanks</p>';
		}
		if($form_registration_passed && isset($_POST['contact_email']) && isset($_POST['contact_content']) && $_POST['name']=="" && 	isset($_REQUEST['contact_checkbox'])){
			$filtered_contact_content=filter_input(INPUT_POST, 'contact_content', FILTER_SANITIZE_SPECIAL_CHARS);
			$contact_content= trim($filtered_contact_content);
			$mail=new PHPMailer_Mailer();
            $mail->SMTPDebug = 1;
            $mail->IsSMTP();  // telling the class to use SMTP
		    $mail->SMTPAuth = true;
		    $mail->WordWrap = 50;
		    $mail->From = $contact_email;
		    $mail->FromName='customer';
		    $mail->AddAddress('sky4life@sky4life.com','customer'); 
		    $mail->Subject  = "customer contact";
		    //$mail->IsHTML(true);		   
		    // message body for the unique user that already been created					   
		    $mail->Body=$contact_content;
		 
            $mail->Send();
            if($mail->Send()){
				//we show the good guy only in one case and the bad one for the rest.
		        echo '<p class="confirmation-message">Your message has been sent to the site manager.<br/>Thanks for your attention to our site.We will contact you soon.</p>';
			}else { 
				echo '<p>Email has not been sent.Please try again.</p>';
			}
		
		}else{
			//echo '<p>Please fill fields properly.thanks.</p>';
		}
	
			
	}
}