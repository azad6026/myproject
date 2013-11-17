<div class="slide-section">
             <ul class="rslides" id="slider1">
             <?php foreach ($data as $key => $value): ?>
			  <li><img src="<?=$value['photo_path'];?>" alt="<?=$value['post_title'];?>">
			  	<div class="caption"><h2><a href="/post_page/<?=substr(utf8_encode($value['post_id']), 0,15);?>"><?=$value['post_title'];?></a></h2><p ><?=stripslashes(substr(utf8_encode($value["post_content"]), 0,70));?>....</p></div>
			  </li>
	     <?php endforeach; ?>			  
	     </ul>
</div>