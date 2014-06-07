(function( $ ) {
 
    $.fn.invite = function() {
 	
 	this.each(function() {
        	
 		var root = $(this);

 		$(this).find('form.invite-form').on('submit', function(){

 			$(this).find('a.add-invite').trigger('click');
 			return false;
 		});

		$(this).find('a.add-invite').on('click', function(){
			var email = $('.invite-form input[name="email"]').val();
			
			if(email.length >0)
			{
				$.ajax({
				        method:'post',
				        url: '/ajax/add-invite',
				      	data: $('.invite-form').serialize(),
				      	dataType:'json',
				        success: function( data ) {
				        	if(data.responsetype == 'success')
				        	{
				        		$('.invite-form input[name="email"]').val('');
				        		

				        		$(template(data.response)).appendTo('ul.invites').fadeIn('fast');
				        		$(document).foundation();
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
		var my_html =  '<li class="c-item" style="display:none">\
		<span>' + data.email + '</span>\
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