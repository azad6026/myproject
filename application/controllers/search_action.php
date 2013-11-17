<?php
class Search_Action_Controller{
	public function main($get_vars=array()){
        $functions = new Functions_Helper;
        if(isset($_REQUEST['search'])){
           //save the search term in a session for use in search result controller
            $term = $_REQUEST["search"];
            $search_request = utf8_decode($term);
            $_SESSION['search_request']=$search_request;
            $search_result->data['search_term']=$search_request;
            //now redirect to result page to get results
            $functions->redirect_to("/search_result/".$_SESSION['search_request']);
           
        }        
	}
}