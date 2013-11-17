<?php
$top_head = new View_Model('top_head');
$bottom_head = new View_Model('bottom_head');
$footer = new View_Model('footer');
$common_scripts = new View_Model('common_scripts');?>
<?=$data['top_head']=$top_head->render(false);?>
<?=$data['head'];?>
<?=$data['bottom_head']=$bottom_head->render(false);?>
<body>
<section id="wrapper">
<?=$data['header'];?>
<section class="main">	
<?=$data['main'];?>
</section>	
<?=$data['footer']=$footer->render(false);?>

</section>
<?=$data['page_specific_scripts'];?>
<?=$data['common_scripts']=$common_scripts->render(false);?>