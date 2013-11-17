<section class="profile-main-section">
<div class="registration-message"><?=$data['msg'];?></div>
<?php $session=new Session_Helper;
      if($session->is_logged_in()) : ?>
<h3>Your Profile Information:</h3>
<?php foreach ($data as $key => $value) :?>
<div class="member-data-section">
<div><label for="email">Email: </label><h4><?=$value['email'];?></h4><div class="edit-profile-data" id="edit_email">Edit Email</div></div>
<div><label for="birthday">BirthDay: </label><h4>13th sep 2001</h4><div class="edit-profile-data" id="edit_birth">Edit BirthDay</div></div>
<div><label for="language">Language: </label><h4> English</h4><div class="edit-profile-data" id="edit_lang">Edit Language</div></div>
<div><label for="language">Password: </label><h4> ********</h4><div class="edit-profile-data" id="edit_lang">Change Password</div></div>
<?php endforeach; ?>
</div>
<? endif; ?>
<div id="edit_area"></div>
</section>