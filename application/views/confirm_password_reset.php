<form  id="password_reset_form" style="padding:20px;" >
  <div id="result_message" > 
    <?=$data['blank_fields'];?>
</div>
	<label for="password">New Password:</label><br/>
	<input type="password" name="password" id="password"  size="30"  value=""/>
<input type="submit" name="submit_reset" id="submit_reset" value="submit" >
</form>