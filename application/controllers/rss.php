<?php
class Rss_Controller{	
	public function main($get_vars=array()){
		$posts_model = new Load_Posts_Model; 
        $rss = new View_Model('rss');
		$rss->data=$posts_model->get_posts();
		$rss->render();
	}
}


