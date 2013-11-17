<?php
	class Confirm_Registeration_Controller{
		public $template = 'confirm_registeration';
		public function main($get_vars=array()){
			$session=new Session_Helper;
			$functions = new Functions_Helper;
			$user_model= new Users_Model;
			$categories_model=new Category_Model;
			global $message;
			$page_specific_scripts=new View_Model('page_specific_scripts');
	    	$page_specific_scripts->data['page_script']="/scripts/profile.js";
	    	$confirm_registeration = new View_Model('confirm_registeration');
	    	$main_content = new View_Model('main_content');
	    	$main_sidebar = new View_Model('main_sidebar');
	    	$master = new View_Model('master');
			//examine and prepare id and security_id for confirmation
			$user_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;
	    	$security_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;	    
			$registered_user=$user_model->find_registered_user($user_id,$security_id);		
			if($registered_user)
			{
				if($registered_user->active==1)
				{
					$message = '<p clss="message">This member is already active ! <a href="/login"> login here</a></p>';
				}else{
					$user_model->update_registered_user($user_id,$security_id);
					$message='<p clss="message">Congratulations '.$registered_user->username.'!  You just confirmed your membership ! Now,start sending your posts <a href="/">here</a></p>';
					$user=$registered_user->username;
					$session->login($user);
					//$functions->redirect_to("?");
				}
			}else {
			
				$message = '<p clss="message">This username/email has not found !</p>';
			
			}

			$confirm_registeration->data['blank_fields']=$message;
			$head=new View_Model('head');
	    	$head_data = array("title" =>"Sky4Life : Profile Page","content"=> "","page_css" =>array("/styles/global.css","/styles	/page.css"));
	        $head->data=$head_data;
	        //$page=!empty($_GET['post_id']) ? (int) trim($_GET['post_id']): 1;
	        $master->data['head']=$head->render(false);
	    	$main_sidebar->data=$categories_model->find_category_name_by_id(); 
	    	$page_specific_scripts->data=array("/scripts/post_page.js");
	    	$main_content->data['main']=$confirm_registeration->render(false);
	    	$main_content->data['sidebar']=false;
	    	$main_content->data['pagination']=false;
	    	$master->data['main']=$main_content->render(false);
	       	$master->data['page_specific_scripts']=$page_specific_scripts->render(false);
	        //render main template
	        $master->render();
	}
}
		