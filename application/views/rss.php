<?php header('Content-Type: text/xml'); ?>
<?php echo'<?xml version="1.0" encoding="ISO-8859-1"?>
	<rss version="2.0">
	<channel>
	<title>sky4life rss feed</title>
	<link>www.sky4life.com</link>
	<description>posts title and description</description>';?>
	<?php foreach($data as $post){
		echo'
	<item>
	<title>'.$post["post_title"].'</title>
	<link>http://www.sky4life.com/post_page/post_id='.$post["post_id"].'</link>
	<pubDate>'.$post["published_date"].'</pubDate>
	</item>';
	}?>
	<?php 
	echo'
	</channel></rss>';?>