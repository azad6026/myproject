<title><?=$data['title'];?></title> 
	<?php foreach ($data['general_css'] as $key => $val) : ?>
	<link  rel="stylesheet" type="text/css" href="<?=$val;?>" media="screen"/>
	<?php endforeach;?>
	<meta name="Description" content="<?=$data['content'];?>" />
	<!--[if lte IE 8]>
	<?php foreach ($data['ie_script'] as $key => $val) : ?>
	<script   src="<?=$val;?>"></script>
	<?php endforeach;?>
	 <![endif]-->
	 <?php foreach ($data['page_css'] as $key => $val) : ?>
	<link  rel="stylesheet" type="text/css" href="<?=$val;?>" media="screen"/>
	<?php endforeach;?>