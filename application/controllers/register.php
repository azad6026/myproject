<?php
class Register_Controller{
	public function main($get_vars=array()){
    	$session=new Session_Helper;
    	$functions = new Functions_Helper;
    	$top_head= new View_Model('top_head');
    	$head= new View_Model('head');
    	$bottom_head= new View_Model('bottom_head');
		$head_data = array("title" =>"Sky4Life : Register" ,"content"=>"","page_css"=>array("/styles/register.css"));
		$head->data=$head_data;
    	$register = new View_Model('register');
    	$page_specific_scripts=new View_Model('page_specific_scripts');
		$page_specific_scripts->data['page_script']="/scripts/register.js";
		$top_head->render();
		$head->render();
		$bottom_head->render();
		$register->render();
		$page_specific_scripts->render();
	}
}
		



	