<?php
class Categorized_Posts_Controller{
	public $template = 'posts';
	public function main($get_vars=array()){
        //create our class instances to use in our controller
	    $posts_model = new Posts_Model;     
        $categories_model=new Category_Model;
        $session=new Session_Helper;
        $pagination_posts = new View_Model('pagination_categorized_posts');    
        $posts = new View_Model('posts');
        $main_content = new View_Model('main_content');
        $main_sidebar = new View_Model('main_sidebar');
        $new_posts = new View_Model('new_posts');
        $popular_posts = new View_Model('popular_posts');
        $categories=new View_Model('categories');
        $head=new View_Model('head');
        $header= new View_Model('header');
        $page_specific_scripts=new View_Model('page_specific_scripts');
        $page_specific_scripts->data['page_script']="/scripts/posts.js";
        $master = new View_Model('master');
	    $category_name= !empty($get_vars) ? urldecode(trim(array_shift($get_vars))) : "sport";
        $head_data = array("title" =>"Sky4Life : ".$category_name." Posts","content"=> 
        "Sky4Life Categorized Posts.You Can Post Your Quotes In Various Categories.","general_css" =>array("/styles/global.css"),"ie_script" =>array("http://html5shiv.googlecode.com/svn/trunk/html5.js"),"page_css" =>array(""));
        $head->data=$head_data;
        $master->data['head']=$head->render(false);
        // $category_name="Life\'s facts"; 
        $page=!empty($get_vars) ? trim(array_shift($get_vars)) : 1;
      
		$per_page=1;
    	//total record count -you could use find_all and then count them in php
    	$total_count=$posts_model->count_categorized_posts($category_name);
    	$pagination=new Posts_Pagination_Helper($page,$per_page,$total_count);
    	$per_page_offset=$pagination->offset();

	    //here we prepare pre and next links for pagination
        $pagination_posts->data['page_name']='categorized_posts'; 
        $pagination_posts->data['category_name']=$category_name;   	
    	$pagination_posts->data['has_previous_page']=false;
    	$pagination_posts->data['has_next_page']=false;
    	if($pagination->total_pages()>1){
    		//to show the current page still and without link
            $pagination_posts->data['current_page']=$page;
            $pagination_posts->data['total_pages']=$pagination->total_pages();
    		if($pagination->has_previous_page()){
    			$pagination_posts->data['has_previous_page']=true;
    			$pagination_posts->data['previous_page']=$pagination->previous_page();
    		}
          
    		if($pagination->has_next_page()){
    			$pagination_posts->data['has_next_page']=true;
    			$pagination_posts->data['next_page']=$pagination->next_page();
    		}

    	}//end of pagination part
		 
        //get posts data to show in main page
        $post_data=$posts_model->get_categorized_posts_per_page($per_page,$per_page_offset,$category_name);
	    $posts->data=$post_data;
	    $header->data=$categories_model->show_category_name();
        $master->data['head']=$head->render(false);
        $master->data['header']=$header->render(false);
        $new_posts->data=$posts_model->get_last_posts();
        $main_sidebar->data['new_posts']=$new_posts->render(false);
        $main_sidebar->data['popular_posts']=false;
        $main_sidebar->data['related_posts']=false;
        $categories->data=$categories_model->find_category_name_by_id();
        $main_sidebar->data['categories']=$categories->render(false);
        $main_content->data['main_header']=false;  
        $main_content->data['main']=$posts->render(false);
        $main_content->data['sidebar']=$main_sidebar->render(false);
        if($pagination->total_pages()>1){
            $main_content->data['pagination']=$pagination_posts->render(false);
        }else{
            $main_content->data['pagination']=false;
        }
        $master->data['main']=$main_content->render(false);
        $master->data['page_specific_scripts']=$page_specific_scripts->render(false);
        //render main template
	    $master->render();
	}
}