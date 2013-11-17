     //already user login codes
      $('#username').bind('change',function(){
         $.post('/login_validation',{ username : $('#username').val()},function(data){
            $('#login_result_message').html(data);
         });
       });  
 $('#password').bind('change',function(){
          $.post('/login_validation',{ username : $('#username').val(),password : $('#password').val()},
          function(data){
          $('#login_result_message').html(data);
        
          });
      });
        $('#submit_login').click(function (event) { 
           event.preventDefault(); 
           //var data = $('#login_form').serializeArray();
           $.ajax({ type:"POST", url:"/login_validation", data: $('#login_form').serializeArray() })
           .done(function (html) {
           if(html == '<p>*Redirecting</p>'){ 
	    window.location.reload(true);
	    }
           return false;  
           }).fail(function(jqXHR, textStatus) { $('#login_result_message').text("request failed"+textStatus); }); 
           return false; 
          });
     //new user register ajax scripts
           $('#new_username').bind('change',function(){
          $.post('/register_validation',{ new_username : $('#new_username').val()},function(data){
            $('#signup_result_message').html(data);
          });
 //   
       }); 
       $('#new_user_password').bind('change',function(){
          $.post('/register_validation',{ new_user_password : $('#new_user_password').val()},function(data){
            $('#signup_result_message').html(data);
          });
        });
//    
        $('#new_user_email').bind('change',function(){
         $.post('/register_validation',{ new_user_email: $('#new_user_email').val()},function(data){
            $('#signup_result_message').html(data);
            });
          });
		
        $('#submit_register').click(function (event) { 
           event.preventDefault(); 
           //var data = $('#registeration_form').serializeArray();
           $.ajax({ type:"POST", url:"/register_validation", data: $('#registeration_form').serializeArray() })
           .done(function (html) { 
           $('#signup_result_message').html(html); 
           return false;  
           }).fail(function(jqXHR, textStatus) { $('#signup_result_message').text("request failed"+textStatus); }); 
           return false; 
        });
        //reset password codes
         $('#reset_password_email').bind('change',function(){
         $.post('/reset_password',{ reset_password_email: $('#reset_password_email').val()},function(data){
            $('#reset_pass_result_message').html(data);
            });
          });
		
        $('#reset_password_form').click(function (event) { 
           event.preventDefault(); 
           $.ajax({ type:"POST", url:"/reset_password", data: $('#reset_password_form').serializeArray() })
           .done(function (html) { 
           $('#reset_pass_result_message').html(html); 
           return false;  
           }).fail(function(jqXHR, textStatus) { $('#reset_pass_result_message').text("request failed"+textStatus); }); 
           return false; 
        });