<li>
	<h2 id="categories" class="categories-list-header">Categories</h2>
	<ul class="sidelist">
	  <?php foreach ($data as $key => $value) : ?>
		<?php $val=$value['category_name']; ?>
		     <li><a href="/categorized_posts/<?=stripslashes($val);?>"><?=stripslashes($value['category_name']);?>&nbsp(<?=$value['posts_count'];?>) 
		      </a></li>
	  <?php endforeach; ?>
	</ul>
</li>