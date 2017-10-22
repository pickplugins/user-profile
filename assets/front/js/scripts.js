jQuery(document).ready(function($) {
	



	$(document).on('change', '.user-profile-edit form', function() {
		
		//alert(form_id);
			 form_id = $(this).attr('id');
			 console.log(form_id);
		
		//alert(form_id);
		
		//
		})





	$('.user-profile-tooltip').tooltipster();


	$(document).on('click', '.user-profile-edit .remove', function() {
		
		$(this).parent().remove();
		
		})



	
	$(document).on('click', '.user_profile_date', function() {
		
		$(this).datepicker({ dateFormat : 'yy-mm-dd' });
		
		})

	// is solved 	
	$(document).on('click', '.follow', function() {
		
		var user_id 	= $(this).attr('user_id');
		
		
		//alert('Hello');
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:user_profile_ajax.user_profile_ajaxurl,
		data: {
			"action"	: "user_profile_ajax_follow", 
			"user_id"	: user_id,
		},
		success: function(data) {
			
			var html = JSON.parse(data)
			
			//$(this).html( html['html'] );
						
			toast_html = html['toast_html'];
			action = html['action'];			
			
			if(action=='unfollow'){
				
				if($(this).hasClass('following')){
					
					$(this).removeClass('following');
					
					}
				$(this).text('Follow');
				$(this).addClass(action);
				
				}
			else if(action=='following'){
				
				if($(this).hasClass('unfollow')){
					
					$(this).removeClass('unfollow');
					
					}
				$(this).text('Following');
				
				$(this).addClass(action);
				}
			else{
				
				}
				
				
			
			

			console.log(html);	
				
			$('.toast').html(toast_html);
			$('.toast').stop().fadeIn(400).delay(3000).fadeOut(400);
			
		}
			});
	})



});	


