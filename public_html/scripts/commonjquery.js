 //contact codes
 $('#contact_email').bind('change',function(){
	 $.post('/contact_validation',{ contact_email: $('#contact_email').val()},function(data){
		 $('#contact_result_message').html(data);
	 });
	 });
	 //
	  $('#contact_content').bind('change',function(){
	 $.post('/contact_validation',{ contact_content: $('#contact_content').val()},function(data){
		 $('#contact_result_message').html(data);
	 });
	 });
	  $('#submit_contact').click(function (event) {
 // event.preventDefault(); 
 var data = $('#contact_form').serializeArray();
 $.ajax({ type:"POST", url:"/contact_validation", data: $('#contact_form').serializeArray() })
	.done(function (html) { 
	$('#contact_result_message').html(html); 
	 $("#contact_form")[0].reset();

	//$('#contact_email').val(''); $('#contact_content').val(''); 
 return false;  
 }).fail(function(jqXHR, textStatus) { $('#contact_result_message').text("request failed"+textStatus); }); 
	return false; 
 }); 
	 
//toggle nav  code for small devices
    $('#menu-toggle').click(function () {
		        
		$('#menu').toggleClass('open');
		$(".membership-accordion div:visible").fadeOut("slow");
$(".membership-accordion h3").removeClass("active");
		e.preventDefault();
        });
	        //membership toggle
$('html').click(function(){
$('.membership-accordion div').fadeOut("slow");
$(".membership-accordion h3").removeClass("active");
});
$(".membership-accordion div").hide();

$('.membership-accordion div').click(function(event){
		event.stopPropagation();
	});
$(".membership-accordion h3").click(function(event){
//e.preventDefault();
event.stopPropagation();
$(this).next("div").toggleClass("open");
if($(this).next("div").is(':visible')){
}else{		
$(this).next("div").fadeToggle("slow")
.siblings("div:visible").fadeOut("slow");
$(this).toggleClass("active");
$(this).siblings("h3").removeClass("active");

}		        
});

    //new post open
    $(".post-form-div").hide();
$(".new-post-section h3").click(function(){
$(this).next("div").slideToggle("100");
$(this).toggleClass("active");
});
//show forget password form
    $('.forgot').click(function(e){
    e.preventDefault();
    $('#reset_password').fadeToggle("slow").siblings("div:visible").fadeOut("slow");
$(this).toggleClass("active");
return false;
});
//upload image here
var btnUpload=$('#photo_file');
new AjaxUpload(btnUpload, {
action: '/upload_file',
name: 'photo_file',
onSubmit:function(file, ext){
if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
        //extension is not allowed 
$('#post_message').text('Only JPG, PNG or GIF files are allowed');
return false;
}
},
    onComplete: function(file, response){
$('#post_message').text(response);
}
       });

        //send new post Ajax call ; 
 $('#submit_post').click(function (event) {
 // event.preventDefault(); 
 var data = $('#create_post_form').serializeArray();
 $.ajax({ type:"POST", url:"/create_post", data: $('#create_post_form').serializeArray() })
	.done(function (html) { 
	$('#post_message').html(html); $('.title').val(''); $('.content').val('');$('#category').val('');
	window.location.reload(true); 
//$('.main').load('/posts_only');
 return false;  
 }).fail(function(jqXHR, textStatus) { $('#post_message').text("request failed"+textStatus); }); 
	return false; 
 }); 