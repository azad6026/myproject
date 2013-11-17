<?php
class Post_Page_Controller
{

    public function main($get_vars=array())
    {
        //create our class instances to use in our controller
        $posts_model = new Posts_Model;
        $categories_model=new Category_Model;
        $session=new Session_Helper;  
        $page_specific_scripts=new View_Model('page_specific_scripts');
        $page_specific_scripts->data['page_script']="/scripts/posts.js";
        $post_page = new View_Model('post_page');
        $main_content = new View_Model('main_content');
        $main_sidebar = new View_Model('main_sidebar');
        $related_posts= new View_Model('related_posts');
        $categories= new View_Model('categories');
        $master = new View_Model('master');
        //create our pagination,get the current page,and count total page through its helper to use it later
        $post_id=!empty($get_vars) ? trim(array_shift($get_vars)) : 1;
        $category_id=$posts_model->get_by_category_id($post_id);
        $_SESSION['post_id']=$post_id;
        $head=new View_Model('head');
        $header= new View_Model('header');
        $head_data = array("title" =>"Sky4Life : Post No.".$post_id,"content"=> "","general_css" =>array("/styles/global.css"),"ie_script" =>array("http://html5shiv.googlecode.com/svn/trunk/html5.js"),"page_css" =>array("/styles/page.css"));
        $head->data=$head_data;
        $header->data=$categories_model->show_category_name();
        //$page=!empty($_GET['post_id']) ? (int) trim($_GET['post_id']): 1;
        $master->data['head']=$head->render(false);
        $post_page->data=$posts_model->get_post_page($post_id);
        $related_posts->data=$posts_model->related_posts_by_category_id($category_id,$post_id);
        $categories->data=$categories_model->find_category_name_by_id($category_id);
        $main_sidebar->data['new_posts']=false;
        $main_sidebar->data['related_posts']=$related_posts->render(false);
        $main_sidebar->data['popular_posts']=false;
        $main_sidebar->data['categories']=$categories->render(false);
        $page_specific_scripts->data=array("/scripts/post_page.js");
        $main_content->data['main']=$post_page->render(false);
        $main_content->data['sidebar']=$main_sidebar->render(false);
        $main_content->data['pagination']=false;
        $master->data['header']=$header->render(false);
        $master->data['main']=$main_content->render(false);
        $master->data['page_specific_scripts']=$page_specific_scripts->render(false);
        //render main template
        $master->render();

    }
}