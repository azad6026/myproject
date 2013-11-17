<fieldset class="fieldset-wrapper">
<form  id="login_form" class="login-form"  action="/login" method="post">
<div id="result_message" > 
  <?=$data['message'];?>
</div>
<label for="username">Username:</label><br/>
<input type="text" name="username" id="username"  size="30"  value=""/>&nbsp<span id="username_message">&nbsp</span><br/>
<label for="password">Password:</label><br/>
<input type="password" name="password" id="password" size="30" VALUE=""/>&nbsp<SPAN id="password_message"></span>&nbsp<br/><br/>
<input type="submit" name="submit_login" id="submit_login" value="Login" >
</form>
<a id='reset_pass' href='' style='color:red;margin-left:18px;'>forgot password?</a>
</fieldset>
<fieldset class="fieldset-wrapper">
<div id="password_reset_div" style="display:none;">
<form  id="reset_password_form" style="padding:20px;">
<label for="email">Email:</label><br/>
<input type="email" name="reset_password_email" id="reset_password_email"  size="30"  value=""/><br/><span id="reset_message">&nbsp</span><br/><br/>
<input type="submit" name="reset_password" id="submit_reset_password" value="Reset Password" >
</form>
</div>
</fieldset>