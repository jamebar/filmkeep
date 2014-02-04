$(function(){
	$('.add-remove-follow').on('click', function(){
		add_remove_follow_clicked($(this));
		return false;
	});
	
	function add_remove_follow_clicked(context)
	{
		
		var follow_user_id = context.data('user_id');
		var this_item = context;
		var my_action = "add";
		if(this_item.hasClass('following'))
			my_action = "remove";
		
		$.ajax({
		    method:'post',
			url: '/ajax/add-remove-follow',
			data: {  follow_user_id: follow_user_id, action:my_action },
			dataType:'json',
			success: function( data ) {
				this_item.toggleClass('following');
				}
		});
	}
})