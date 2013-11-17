// $(document).ready(function(){

$('#email').bind('change',function(){
   $.post('/contact_validation',{ email : $('#email').val()},function(data){
      $('#result_message').html(data);
      });
    });

  $('#submit_contact').click(function (event) { 
     event.preventDefault(); 
     // var data = $('#contact_form').serializeArray();
     $.ajax({ type:"POST", url:"/contact_validation", data: $('#contact_form').serializeArray() })
     .done(function (html) { 
     $('#result_message').html(html); 
     //$('#email').val(''); $('#opinion').val('');  
     return false;  
     }).fail(function(jqXHR, textStatus) { $('#result_message').text("request failed"+textStatus); }); 
     return false; 
  });

// });