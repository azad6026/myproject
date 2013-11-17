$('#username').bind('change',function(){
    $.post('/register_validation',{ username : $('#username').val()},function(data){
      $('#result_message').html(data);
    });

 }); 
 $('#password').bind('change',function(){
    $.post('/register_validation',{ password : $('#password').val()},function(data){
      $('#result_message').html(data);
    });
  });
 //here you must pass both  password and repeated_password for ajax 
 $('#repeated_password').bind('change',function(){
   $.post('/register_validation',{ password : $('#password').val(),repeated_password : $('#repeated_password').val()},function(data){
   $('#result_message').html(data);
  });
   });

  $('#email').bind('change',function(){
   $.post('/register_validation',{ email : $('#email').val()},function(data){
      $('#result_message').html(data);
      });
    });
  $('#submit_register').click(function (event) { 
     event.preventDefault(); 
     //var data = $('#registeration_form').serializeArray();
     $.ajax({ type:"POST", url:"/register_validation", data: $('#registeration_form').serializeArray() })
     .done(function (html) { 
     $('#result_message').html(html); 
     return false;  
     }).fail(function(jqXHR, textStatus) { $('#result_message').text("request failed"+textStatus); }); 
     return false; 
});