<?php

class Create_Post_Controller
{

		public function main($get_vars=array())
		{
			$session=new Session_Helper;
			$functions=new Functions_Helper;
			if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category']) ){
			 
				$posts_model = new Posts_Model;
				$category_model =new Category_Model;
				$lookup_model = new Lookup_Posts_Model;
				$posts_model->post_title=$lookup_model->post_title=$title = trim(htmlentities($_POST['title']));
				$posts_model->post_content=$lookup_model->post_content=$content = trim(htmlentities($_POST['content']));	
				if(isset($_SESSION['photo_name'])){
					$posts_model->photo_path=$photo_path='/images/posts_images/'.$_SESSION['photo_name'];
				}else{
					$posts_model->photo_path=$photo_path="/images/posts_images/default.jpg";
				}
				
				$posts_model->username=$_SESSION['username'];
				$posts_model->published_date=strftime("%Y-%m-%d %H:%M:%S", time());
			    $posts_model->category_id=$category_model->find_category_id_by_name(trim($_POST['category']));
				//$posts_model->category_id=12;
				if(($title!="") && ($content!="")){
					$posts_model->create();
					$lookup_model->create();
					echo '<p class="message">Your post has been submitted.</p>';
				}
				else{
					echo '<p class="message">Please fill the fields properly'.$_POST["category"].'</p>';
					
				}
		}
		
	}
}