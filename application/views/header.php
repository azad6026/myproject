<noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p>
                    <strong>JavaScript seems to be disabled in your browser.</strong><br />
                    You must have JavaScript enabled in your browser to utilize the functionality of our website.                </p>
            </div>
        </div>
    </noscript>
<section class="main-header" >
    <h1 class="site-logo">
    <a href=""><img src="/images/s4l.gif" alt="sky4life"/>
    <b></b>
    </a>
    </h1>
    <?php
    $session=new Session_Helper;
    if($session->is_logged_in()) : 
    $users=new Users_Model;
    $user_data=$users->find_all();?>
    <div class="membership-accordion">
    <h3 class=""><a href="/logout">Sign Out</a></h3>
    <h3 class=""><a href="/profile"><?=$_SESSION['username']?></a></h3>
    </div>
    <?php endif; ?> 
    <?php if(!$session->is_logged_in()) :?> 
    <div class="membership-accordion">
    <h3 class="">Login</h3>
    <div>
    <form id="login_form" class="login-form">
    <p id="login_result_message" class="message"> 
    <?=$data['message'];?>
    </p>
    <label for="username">username:</label></br><input type="text" name="username"  id="username"/></br>
    <label for="password">password:</label></br><input type="password" name="password"  id="password"/></br><br/>
    <p class="forgot">
    <a href="#" id="resend_password_link">Forgot your password?</a>        </p>
    <input type="submit" value="Login" id="submit_login"/>
    </form>
    </div>
    <h3 class="">Sign Up</h3>
    <div>
    <form id="registeration_form" class="registeration-form">
    <p id="signup_result_message" class="message"> 
    <?=$data['message'];?>
    </p>
    <label for="new_username">username:</label><br/><input type="text" name="new_username" id="new_username"/><br/>
    <label for="new_user_password">password:</label><br/><input type="password" name="new_user_password" id="new_user_password"/><br/>
    <label for="new_user_email">email:</label><br/><input type="email" name="new_user_email" id="new_user_email"/><br/><br/>
    <label for="name">Please do not write anything in the field below.Thanks</label>
    <input type="text" name="name" class="name" id="name" value=""/><br/>
    <input type="checkbox" id="signup_checkbox" name="signup_checkbox" value=""/>I am a human not robot.
    <input type="submit" value="Sign Up" id="submit_register" name="submit_register"/>
    </form>
    </div>
    <div  id="reset_password" class="forget-pass-div">
    <form id="reset_password_form">
     <p id="reset_pass_result_message" class="message"> 
    <?=$data['message'];?>
    </p>
    <label for="email">email:</label><br/><input type="email" id="reset_password_email" name="reset_password_email"/><br/>
    <input type="submit"  value="Reset Password"/>
    </form>
    </div>
    </div>
    <?php endif; ?>
    <nav class="top-nav">
     <a id="menu-toggle"  class="toggle-menu"  href="#">Menu</a>
    <ul id="menu" class="main-nav">
      <li class=" main-nav-li">
        <a href="/" class="main-nav-a">home<div class="icon-arrowdown"></div></a>
      </li>
      <li class="main-nav-li">
        <a href="#categories" class="main-nav-a">categories</a>
        <div class="main-nav-dd">          
        <?php 
         $category_names=array_chunk($data, 4, true);
         foreach ($category_names as $category){
          ?>
         <div class="main-nav-dd-column">
            <ul class="common-ul-style main-nav-subnav">  
            <?php  foreach ($category as $category_chunk){ ?>
            <li><a href="/categorized_posts/<?=$category_chunk["category_name"];?>"><?=$category_chunk["category_name"];?></a>
      </li>
      <?php }?>
      </ul>
      </div>
      <?php 
      } 
      ?>
       </div>
      </li>
      <li class=" main-nav-li"><a href="#contact" class="main-nav-a">contact</a></li>
    </ul>
  </nav>
  <div  class=" search-section ">
       <form  id="search_form" action="/search_action" method="post">
        <span><input id="submit_search" type="submit" name="submit" class="button-search" value="search" /></span>
       <span><label for="search" class="search-label">Search</label>
        <input  id="search" name="search" type="text" value="" placeholder="">
         </span>                 
         </form>
  </div>  
</section>