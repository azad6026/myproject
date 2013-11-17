<?php foreach ($data as $key => $value) :?>
<article  class="post" id='<?=$value['post_id'];?>'>
	<h2>
						<a href="/post_page/<?=stripslashes($value['post_id']);?>">
						<span class="post-category"><?=stripslashes($value['category_name']);?></span>
						<span class="post-title"><?=stripslashes($value['post_title']);?></span></a>
						</h2>
						<ul class="postmetadata"> 
							<li class="post-author">By
							 <a rel="author" href="/profile" 
							 title="Posts by <?=stripslashes($value['username']);?>" ><?=stripslashes($value['username']);?></a>
							</li>
					    </ul>
						<p><a href='<?=$value['photo_path'];?>'>
	                    <img alt='<?=$value['post_title'];?>' src='<?=$value['photo_path'];?>'/></a></p>
					    <p><?=stripslashes($value['post_content']);?></p>
					    <a class="continue-reading" href='/post_page/<?=$value['post_id'];?>'>more</a>				
					    <ul class="postmetadata">
					     <li class="post-date"><?=$value['published_date'];?></li>
				         <li class="post-tags"><a href="/categorized_posts/<?=stripslashes($value['category_name']);?>"><?=stripslashes($value['category_name']);?></a> 
				         </li>            
				         	<li class="post-comments"><a href='/post_page/<?=$value['post_id'];?>' title='<?=stripslashes($value['post_title']);?>'>
				         		<?=$value['comments_count'];?> Comments</a></li>
				        </ul>					
</article>
<?php endforeach; ?>