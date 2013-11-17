<?php
class Search_Result_Controller{
	public function main($get_vars=array()){
		 //create our class instances to use in our controller
        $lookup_posts_model = new Lookup_Posts_Model;
        $posts_model= new Load_Posts_Model;
        $categories_model=new Category_Model;
        $session=new Session_Helper;        
        $pagination_result_search = new View_Model('pagination_result_search');
        $head=new View_Model('head');
        $header= new View_Model('header');
        $page_specific_scripts=new View_Model('page_specific_scripts');
        $page_specific_scripts->data['page_script']="";
        $search_result= new View_Model('search_result');
        $main_content = new View_Model('main_content');
        $main_sidebar = new View_Model('main_sidebar');
        $new_posts = new View_Model('new_posts');
        $categories=new View_Model('categories');
        $master = new View_Model('master');
        $term_to_find=!empty($get_vars) ? trim(array_shift($get_vars)) : "_";
        $page=!empty($get_vars) ? trim(array_shift($get_vars)) : 1;
        $_SESSION['search_request']=$term_to_find;
        $head_data = array("title" =>"Sky4Life : Search Results For : ".$term_to_find,"content"=> 
        "In Sky4Life You Can Find Different Quotes","general_css" =>array("/styles/global.css"),"ie_script" =>array("http://html5shiv.googlecode.com/svn/trunk/html5.js"),"page_css" =>array("/styles/search.css"));
        $head->data=$head_data;
        //create our pagination,get the current page,and count total page through its helper to use it later
        $per_page=5;
        $total_count=$lookup_posts_model->count_searched_posts($term_to_find);
        $pagination=new Posts_Pagination_Helper($page,$per_page,$total_count);
        $per_page_offset=$pagination->offset();       
        //total record count -you could use find_all and then count them in php       
        $search_result->data=$lookup_posts_model->find_search_term($term_to_find,$per_page,$per_page_offset);       
        //here we prepare pre and next links for pagination            
        $pagination_result_search->data['page_name']='search_result';
        $pagination_result_search->data['search_term']=$term_to_find;
        $pagination_result_search->data['has_previous_page']=false;
        $pagination_result_search->data['has_next_page']=false;
        if($pagination->total_pages()>1){
            //to show the current page still and without link
            $pagination_result_search->data['current_page']=$page;
            $pagination_result_search->data['total_pages']=$pagination->total_pages();            
            if($pagination->has_previous_page()){
                $pagination_result_search->data['has_previous_page']=true;
                $pagination_result_search->data['previous_page']=$pagination->previous_page();
            }
            if($pagination->has_next_page()){
                $pagination_result_search->data['has_next_page']=true;
                $pagination_result_search->data['next_page']=$pagination->next_page();
            }
        }//end of pagination part
        $master->data['head']=$head->render(false);
        $header->data=$categories_model->show_category_name();
        $new_posts->data=$posts_model->get_last_posts();
        $categories->data=$categories_model->find_category_name_by_id();
        $main_sidebar->data['new_posts']=$new_posts->render(false);
        $main_sidebar->data['popular_posts']=false;
        $main_sidebar->data['related_posts']=false;
        $main_sidebar->data['categories']=false;
        $main_content->data['main_header']=false; 
        $main_content->data['new_post']=false; 
        $main_content->data['main']=$search_result->render(false);
        $main_content->data['sidebar']=$main_sidebar->render(false);
        if($pagination->total_pages()>1){
            $main_content->data['pagination']=$pagination_result_search->render(false);
        }else{
            $main_content->data['pagination']=false;
        }
        $master->data['main']=$main_content->render(false);
        $master->data['header']=$header->render(false);
        $master->data['page_specific_scripts']=$page_specific_scripts->render(false);
        //render main template
        $master->render();
	}
}