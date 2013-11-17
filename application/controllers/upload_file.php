<?php
class Upload_File_Controller{
	public function main($get_vars=array()){
		$session=new Session_Helper;	
		$_SESSION['photo_name']=$_REQUEST['photo_file'];
		echo $_SESSION['photo_name'];
		/* to avoid warnings like : [function.move-uploaded-file]: failed to open stream: No such file or directory /or : stat filesize error,
			make sure to not to define your path completely,use getcwd() to find out
		*/
		$uploaddir = '/home/sky4life/public_html/images/posts_images/'; 
		$uploadfile_dir = $uploaddir . basename($_FILES['photo_file']['name']);					
		if(move_uploaded_file($_FILES['photo_file']['tmp_name'], $uploadfile_dir)){
		}	
		$path_parts = pathinfo($uploadfile_dir);
		$extension=$path_parts['extension'];
		$_SESSION['photo_name']= $path_parts['basename'];
		$max_photo_size=1500000;
		if(filesize($uploadfile_dir)>$max_photo_size){
			echo 'This photo is too large.maximum size:1.5Mb';
			while(is_file($uploadfile_dir) == TRUE)
	         {
	            chmod($uploadfile_dir, 0666);
	            unlink($uploadfile_dir);
	         }
		}else{
			if($extension == 'jpg') {
				echo $_SESSION['photo_name'].' has been uploaded.';
			}
			elseif($extension == 'gif') {
				echo $_SESSION['photo_name'].' has been uploaded.';
			}elseif($extension == 'png') {
				echo $_SESSION['photo_name'].' has been uploaded.';
			}
			elseif($extension == 'jpeg') {
				echo $_SESSION['photo_name'].' has been uploaded.';
			}else{
				echo 'only jpeg,jpg,png,gif are supported';
				while(is_file($uploadfile_dir) == TRUE){
	            chmod($uploadfile_dir, 0666);
	            unlink($uploadfile_dir);
	            }
			}
		} 
	}
}