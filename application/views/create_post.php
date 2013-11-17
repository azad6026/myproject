 <?php
$session=new Session_Helper;
if($session->is_logged_in()) :?>
<section id="new-post-section" class="new-post-section">
<h3 id="new_post" class="new-post-link">New Post</h3>
<div class="post-form-div">		
<div id="post_message" class="message"></div>
<div  class="photo-form">
<div id="photo_file" >Upload Post Photo</div>
</div>
<form id="create_post_form" class="new-post-form" >
<label for="category">Post Category:  </label><br/>
<select name="category" id="category">
<option value="None" selected="selected"><!--select one--></option>
<?php foreach ($data as $key => $value) :?>
<option value="<?=$value['category_name'];?>"><?=$value['category_name'];?></option>
<?php endforeach; ?>
</select><br/>
<label for="itle">Post Title:</label><br/>
<input type="text" name="title" class="title" ><br/>
<label for="content">Post Content:</label><br/>
<textarea name="content" class="content"></textarea><br/>
<input type="hidden" id="hidden_post" class="hidden-post"/>
<input type="submit" name="submit_post" id="submit_post" value="submit post"/><br/>
</form>			
</div>	
</section>
<?php endif; ?>