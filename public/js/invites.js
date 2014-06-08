(function( $ ) {
 
    $.fn.invite = function() {
 	
 	this.each(function() {

 		var root = $(this);

 		$(this).find('.customize-message').on('change', function(){
 			if($(this).is(':checked'))
 			{
 				$('.invite-message').slideDown('fast');
 			}
 			else
 			{
 				$('.invite-message').slideUp('fast');
 			}
 		});

 		$(this).find('form.invite-form').on('submit', function(){

 			$(this).find('a.add-invite').trigger('click');
 			return false;
 		});

		$(this).find('a.add-invite').on('click', function(){
			var email = $('.invite-form input[name="email"]').val();
			
			if(email.length >0)
			{
				$('.spinner').spin({
		        		lines: 9,
					length: 5,
					width: 3,
					radius: 10,
					top:'10px',
					left:'10px'
		        	});
				$.ajax({
				        method:'post',
				        url: '/ajax/add-invite',
				      	data: $('.invite-form').serialize(),
				      	dataType:'json',
				        success: function( data ) {
				        	$('.spinner').spin(false);
				        	if(data.responsetype == 'success')
				        	{
				        		$('.invite-form input[name="email"]').val('');
				        		

				        		$(template(data.response)).appendTo('ul.invites').fadeIn('fast');
				        		$('document').foundation();
				        		addAlert( "Your invite to " + data.response.email + " has been sent and added below.");
				        		$('.invite-form')[0].reset();
				        	}
				        	else
				        	{
				        		addAlert(data.response);
				        	}
				            	
				  	}
				});
			}
			
			return false;
		});

		

	 	$(this).find('ul.invites').on('click' , '.delete-invite', function(){

	 		var this_item = $(this);
	 		var id = this_item.data('id');
	 		
	 		if(id)
	 		{
	 			$.ajax({
				        method:'post',
				        url: '/ajax/delete-invite',
				      	data: {id: id},
				      	dataType:'json',
				        success: function( data ) {
				        	
			        		this_item.parents('.c-item').slideUp();
				  	}
				});
	 		}
	 		

	 	});

		
		
	});

	function template(data)
	{
		var redeemed = (data.redeemed ==1) ? 'yes' : 'no';
		var my_html =  '<li class="c-item" style="display:none">\
		<span>' + data.email + '</span><br>\
		<small>Invite code: <span>' + data.code + '<span> </small> &nbsp;&nbsp;|&nbsp;&nbsp;\
		<small>Redeemed: <span>' + redeemed + '<span> </small>\
		<div class="right">\
		<a href="javascript:;" data-dropdown="drop' + data.id + '" class=" dropdown" ><i class="step fi-x size-36" style="font-size:22px;color:#178FE1;" ></i></a>\
		<ul id="drop' + data.id + '" data-dropdown-content class="f-dropdown">\
		  <li><a class="delete-invite" data-id="' + data.id + '" href="javascript:;">Yes, delete <i class="step fi-trash " style="font-size:18px;color:#d50606;margin-left:1em" ></i></a></li>\
		  <li><a href="javascript:;">no, nevermind</a></li>\
		</ul>\
		</div>\
		</li>'

		return my_html;
	}

	
    };
 
}( jQuery ));


$('#invites').invite();