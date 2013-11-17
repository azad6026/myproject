<?php
class Posts_Controller{ 
    public function main($get_vars=array()){
        $posts_model = new Posts_Model;
        $categories_model=new Category_Model;
        $session=new Session_Helper;
        $page_specific_scripts=new View_Model('page_specific_scripts');
        $page_specific_scripts->data['page_script']="/scripts/posts.js";
        $pagination_posts = new View_Model('pagination_posts');
        $main_slider = new View_Model('main_slider');
        $create_post=new    View_Model('create_post');
        $posts = new View_Model('posts');
        $main_content = new View_Model('main_content');
        $main_sidebar = new View_Model('main_sidebar');
        $new_posts = new View_Model('new_posts');
        $popular_posts = new View_Model('popular_posts');
        $categories=new View_Model('categories');
        $head=new View_Model('head');
        $header= new View_Model('header');
        $master = new View_Model('master');  
        //create our class instances to use in our controller
        $head_data = array("title" =>"Sky4Life : The Real Life's Sky","content"=> "","general_css" =>array("/styles/global.css"),"ie_script"=>array("http://html5shiv.googlecode.com/svn/trunk/html5.js"),"page_css" =>array(""));
        $head->data=$head_data;
        $master->data['head']=$head->render(false);
        //here we prepare pre and next links for pagination    
        //create our pagination,get the current page,and count total page through its helper to use it later
        $page=!empty($get_vars) ? trim(array_shift($get_vars)) : 1;
        if($page == ''){
            $page='1';
        }
        $per_page=3;
        //total record count -you could use find_all and then count them in php
        $total_count=$posts_model->count_all();
        $pagination=new Posts_Pagination_Helper($page,$per_page,$total_count);
        $per_page_offset=$pagination->offset();
        // $parsed=explode('/',$request);
        // $page_name=array_shift($parsed);  //Shift an element off the beginning of array:here page_name 
        $pagination_posts->data['page_name']='posts';
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
        //now for our main_content_header,we should examine user`s state
        $create_post->data=$categories_model->find_category_name_by_id();   
        //get posts data to show in main page
        $post_data=$posts_model->get_posts_per_page($per_page,$per_page_offset);
        $posts->data=$post_data;
        $header->data=$categories_model->show_category_name();
        $main_slider->data=$posts_model->get_last_posts();   
        //get specific scripts for this page
        $page_specific_scripts->data=array("/scripts/ajaxupload3.js","/scripts/responsiveslides.min.js","http://www.google-analytics.com/urchin.js","/scripts/posts.js");
        $new_posts->data=$posts_model->get_last_posts();
        $main_sidebar->data['new_posts']=$new_posts->render(false);
        $main_sidebar->data['popular_posts']=false;
        $main_sidebar->data['related_posts']=false;
        $categories->data=$categories_model->find_category_name_by_id();
        $main_sidebar->data['categories']=$categories->render(false);
        $main_content->data['main_header']=$main_slider->render(false); 
        $main_content->data['new_post']=$create_post->render(false); 
        $main_content->data['main']=$posts->render(false);
        $main_content->data['sidebar']=$main_sidebar->render(false);
        $main_content->data['pagination']=$pagination_posts->render(false);
        $master->data['header']=$header->render(false);
        $master->data['main']=$main_content->render(false);
        $master->data['page_specific_scripts']=$page_specific_scripts->render(false);
        //render main template
        $master->render();
    }
}