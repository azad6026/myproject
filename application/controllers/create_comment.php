<?php
class Create_Comment_Controller
{

		public function main($get_vars=array())
		{
			$session=new Session_Helper;
			if($session->is_logged_in()){
				if(isset($_POST['comment_content']) && $_POST['comment_content']!="" ){			
					$comments_model = new Comment_Model;
					$comments_model->comment_content= trim(htmlentities($_POST['comment_content']));
					$comments_model->post_id= trim($_REQUEST['post_id']);
					$comments_model->author=$_SESSION['username'];
					$comments_model->published_date=strftime("%Y-%m-%d %H:%M:%S", time());
					//now create new comment for this posts
					$comments_model->create();
				}else{
					echo '<p>please write your comment and then send it.</p>';
				}
		    }else{
		      	echo '<p>Please login to send your comment.Thanks.</p>';
		    }
		
	}
}