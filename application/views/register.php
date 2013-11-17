<body class="main-body">
  <div class="page-logo"><img src="/images/reglogo.png"></div>
<p class="registration-description">Share your thoughts here,where we name it <span class="highlight">sky of your life</span>.<br/>Tell the others your ideas and enjoy to find new friends and minds.
Welcome and enjoy your sky. </p>
<form  id="registeration_form" class="registration-form" >
  <span id="result_message" class="input-wrapper output-message" > 
  </span>
  <!--allways remember to close the label or you will stuck in this form forever for no tabing available -->
  <div class="row-wrapper">
  <label class="registration-label" for="username">Username:</label>
  <div class="input-wrapper">
  <input type="text" class="registration-input" id="username" name="username"  value="<?php if(isset($_POST['username'])){echo $_POST['username'];}?>"/>&nbsp<span id="username_message">&nbsp</span><br/>
  </div>
  </div>
  <div class="row-wrapper">
  <label class="registration-label" for="password">Password:</label>
  <div class="input-wrapper">
  <input type="password" id="password"  class="registration-input" name="password"  value=""/>&nbsp<span id="password_message">&nbsp</span><br/>
  </div>
  </div>
  <div class="row-wrapper">
  <label class="registration-label" for="reapeted_password">Re-Password:</label>
  <div class="input-wrapper">
  <input type="password" id="repeated_password"  class="registration-input" name="repeated_password"  value=""/>&nbsp<span id="repeated_password_message">&nbsp</span><br/>
  </div>
  </div>
  <div class="row-wrapper">
  <label class="registration-label" for="email">Email:</label>
  <div class="input-wrapper">
  <input type="email" id="email"   id="email" class="registration-input" name="email"  value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" >&nbsp<span id="email_message">&nbsp</span><br/><br/>
  </div>
  </div>
  <div class="submit-wrapper">
  <input type="submit" border="0"  name="register" id="submit_register" value="Sign Up"/>
  </div>
</form>

