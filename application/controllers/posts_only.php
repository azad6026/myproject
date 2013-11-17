<?php

class Posts_Only_Controller{
    public function main($get_vars=array()){
        //create our class instances to use in our controller
        $posts_model = new Posts_Model;
        $categories_model=new Category_Model;
        $pagination_posts = new View_Model('pagination_posts');
        $main_slider = new View_Model('main_slider');
        $create_post=new    View_Model('create_post');
        $posts = new View_Model('posts');
        $main_content = new View_Model('main_content');
        $main_sidebar = new View_Model('main_sidebar');
        //create our pagination,get the current page,and count total page through its helper to use it later
        $page=!empty($get_vars) ? trim(array_shift($get_vars)) : 1;
        $per_page=5;
        //total record count -you could use find_all and then count them in php
        $total_count=$posts_model->count_all();
        $pagination=new Posts_Pagination_Helper($page,$per_page,$total_count);
        $per_page_offset=$pagination->offset();
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
        //get posts data to show in main page
        $posts->data=$posts_model->get_posts_per_page($per_page,$per_page_offset);
        $create_post->data=$categories_model->find_category_name_by_id();   
        $main_slider->data=$posts_model->get_last_posts();   
        $main_sidebar->data=$categories_model->find_category_name_by_id();
        $main_content->data['main_header']=$main_slider->render(false); 
        $main_content->data['new_post']=$create_post->render(false); 
        $main_content->data['main']=$posts->render(false);
        $main_content->data['sidebar']=$main_sidebar->render(false);
        $main_content->data['pagination']=$pagination_posts->render(false); 
        echo $main_content->render();

    }
}