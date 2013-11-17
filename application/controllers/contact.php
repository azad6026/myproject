<?php
class Contact_Controller
{
	public $template = 'contact';
	
	public function main($get_vars=array())
	{
		$session=new Session_Helper; 
    	$functions = new Functions_Helper;
    	$head= new View_Model('head');
    	$title=new View_Model('title');
		$title->data['title']="Sky4Life : Contact Us ";
		$logo= new View_Model('logo');
		$nav= new View_Model('nav');		
		$contact = new View_Model('contact');
		$footer = new View_Model('footer');
		$master = new View_Model('master');
		$main_content = new View_Model('main_content');
		$page_specific_scripts = new View_Model('page_specific_scripts');

		
		if($session->is_logged_in()) {
        $nav->data['welcome_user']=true;
		} 
		 else {
        $nav->data['welcome_user']=false;
		} 
		$message="<p style='word_wrap:50;'>Welcome to our website.</p>";
		$contact->data['message']=$message;
		$main_content->data['main_header']=false;
		$main_content->data['main1']=false;
		$main_content->data['main2']=$contact->render(false);
		$page_specific_scripts->data['page_script']="/scripts/contact.js";
		$master->data['head']=$head->render(false);
		$master->data['title']=$title->render(false);
		$master->data['logo']=$logo->render(false);
		$master->data['nav']=$nav->render(false);
		$master->data['footer']=$footer->render(false);	
		$master->data['main']=$main_content->render(false);
		$master->data['page_specific_scripts']=$page_specific_scripts->render(false);
		$master->render();
	}
}