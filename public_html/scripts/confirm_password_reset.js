  // $(document).ready(function(){

  $('#password').bind('change',function(){

         $.post('/change_password_validation',{ password : $('#password').val()},function(data){
            $('#result_message').html(data);
            });
          });

 $('#submit_reset').click(function (event) { 
           event.preventDefault(); 
           //var data = $('#reset_password_form').serializeArray();
           $.ajax({ type:"POST", url:"/change_password_validation", data: $('#password_reset_form').serializeArray() })
           .done(function (html) { 
           $('#reset_message').html(html); 
            $('#password').val('');  
           return false;  
           }).fail(function(jqXHR, textStatus) { $('#reset_message').text("request failed"+textStatus); }); 
           return false; 
        });
       
  // });
