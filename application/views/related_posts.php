<li class="sidebar-inner-section related-posts-section">
						    	<div class="inner">
									<h2>Related Posts</h2>
									<ul class="sidelist">
									 	<?php foreach ($data as $key => $value) : ?>
									     <li><a href="/post_page/<?=stripslashes($value['post_id'])?>"><?=stripslashes($value['post_title']);?> 
									      </a><p><?=stripslashes($value['published_date']);?></p></li>
								  <?php endforeach; ?>
								</ul>
							    </div>
</li>	