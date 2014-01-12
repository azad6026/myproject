<?php foreach ($data as $key => $value) :?>		
		<article  class="post" id='<?=$value['post_id'];?>'>
	<h2>
						<a href="/<?=stripslashes($value['post_title']);?>"
						rel="bookmark" title="<?=stripslashes($value['post_title']);?>">
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
					    <ul class="postmetadata">
					     <li class="post-date"><?=$value['published_date'];?></li>            
				         	<li class="post-comments"><a href='/post_page/<?=$value['post_id'];?>' title='<?=stripslashes($value['post_title']);?>'>
				         	
				         		<?=count($value['comments_count']);?> Comments</a>
				         		</li>
				        </ul>
				        <?php if($_SESSION['username']==$value['username']): ?>
<span><a href="/edit_post/<?=$value['post_id'];?>">Edit</a></span>
<?php endif; ?>
		<hr/>
        <article class="comments" id="comments">
        	<header>
        	<form id="comment_form" >
        	<div id="comment_result_message" class="message">
        	<?php $session=new Session_Helper;
		  if(!$session->is_logged_in()): ?>
        	<p>Please login to send your comment.Thanks.</p>
        	<?php endif; ?>
        	</div>
       		<label for="comment">Comment:</label><br/><textarea id="comment_content" name="comment_content"></textarea><br/>
       		<input type="submit" name="submit_comment" id="submit_comment" value="send"/>
        	</form>
        	</header>	
        	<h3>Comments:</h3>
        	
        	
	        	<?php foreach ($value['comment'] as $key => $val) :?>
	        	<ul class="postmetadata">
	        	<li class="comment-content"><?=stripslashes($val['comment_content']);?></li>
	        	<li class="comment-writer"><a href=""><?=$val['author'];?></a></li>
	        	<li class="comment-date"><?=$val['published_date'];?></li>
	        	 </ul>
	        	<?php endforeach; ?>   
        </article>					
</article>
<?php endforeach; ?>
