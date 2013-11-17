$('#submit_comment').click(function(event){
		event.preventDefault();
		$.post('/create_comment',{post_id:$('.post').attr('id'),comment_content:$('#comment_content').val()})
			.done(function(data){
				$('#comment_result_message').html(data);
				$('#comment_content').val('');
				window.location.reload=true;
				return false;
			}).fail(function(jqXHR, textStatus) { $('#comment_result_message').text("request failed"+textStatus); }) ;
		return false;
});