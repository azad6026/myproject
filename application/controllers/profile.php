<?php
class Profile_Controller{
	public function main($get_vars=array()){
		$session=new Session_Helper;
		$functions = new Functions_Helper;
		$user_model= new Users_Model;
		$categories_model=new Category_Model;
		global $message;
		$page_specific_scripts=new View_Model('page_specific_scripts');
    	$page_specific_scripts->data['page_script']="/scripts/profile.js";
    	$profile = new View_Model('profile');
    	$main_content = new View_Model('main_content');
    	$master = new View_Model('master');
    	if(!$session->is_logged_in()){
		//examine and prepare id and security_id for confirmation new  user registration
		$user_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;
    	$security_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 0;	    
		$registered_user=$user_model->find_registered_user($user_id,$security_id);		
		if($registered_user)
		{
			if($registered_user->active==1)
			{
				$message = '<p clss="message">Please login now.</p>';
			}
			else
			{
				$user_model->update_registered_user($user_id,$security_id);
				$message='<p clss="message">Congratulations '.$registered_user->username.'!  You just confirmed your membership ! Now,Login to the site and start sending your posts.</p>';
				$user=$registered_user->username;
			}
		}else{
		
			$message = '<p clss="message">Please register to the site or login if you are a member already.</p>';
		
		}

			$profile->data['msg']=$message;
		}else{
			$user_model= new Users_Model;
			$name=$user_model->get_user_data($_SESSION['username']);
			$profile->data=$user_model->get_user_data($_SESSION['username']);
	        //$profile->data=$user_model-> get_user_data($_SESSION['username']);
		}
		$head=new View_Model('head');
		$header= new View_Model('header');;
        $head_data = array("title" =>"Sky4Life : Profile","content"=> "","general_css" =>array("/styles/global.css"),"ie_script" =>array("http://html5shiv.googlecode.com/svn/trunk/html5.js"),"page_css" =>array("/styles/profile.css"));
        $head->data=$head_data;
        $header->data=$categories_model->show_category_name();
        $master->data['head']=$head->render(false);; 
    	$page_specific_scripts->data=array("/scripts/profile.js");
    	$main_content->data['main_header']=false; 
        $main_content->data['new_post']=false;
    	$main_content->data['main']=$profile->render(false);;
    	$main_content->data['sidebar']=false;
    	$main_content->data['pagination']=false;
    	$master->data['main']=$main_content->render(false);
    	$master->data['header']=$header->render(false);
       	$master->data['page_specific_scripts']=$page_specific_scripts->render(false);
        //render main template
        $master->render();
	}
}