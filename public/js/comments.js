(function( $ ) {
 
    $.fn.commentify = function() {
 	
 	this.each(function() {
        	
 		var root = $(this);
		var this_box = $(this).find('.comment-box');
		var this_type = this_box.attr('id').split('-')[0];
		var this_id = this_box.attr('id').split('-')[1];
		var ctype = this_box.data('ctype');
		var num = (ctype === "tease") ? 5 : 0;

		$.ajax({
		        method:'post',
		        url: '/ajax/get-comments',
		      	data: {object_type:this_type, object_id: this_id, num: num},
		      	dataType:'json',
		        success: function( data ) {
		        	if(data)
		        	{
		        		if(data.length>0)
		        		{
		        			this_box.find('.filler').hide();
		        		}
		        		
		        		$.each(data, function(index,val){
		        			var c = {
		        				id: val.id,
			        			comment: val.comment.replace(/\r?\n/g, '<br />'),
			        			username: val.username,
			        			name: val.name,
			        			profile_pic: val.profile_pic,
			        			created: val.created_at,
			        			comment_user_id: val.user_id,
			        			spoiler: val.spoiler
			        		}
			        		this_box.append(comment_template(c));
		        		});
		        		if(data.length>0)
		        			this_box.parents('.comment-con').show();
		        	}
		            	
		  	}
		});
		
		$(this).parents('.feed-item').find('.comment-icon').on('click',function(){
			var comment_con = root.parents('.comment-con');
			comment_con.slideDown();
			comment_con.find('.comment_form textarea').focus();

		});

		this_box.on('click','.delete_comment', function(){
			var this_comment = $(this);
			$.ajax({
				        method:'post',
				        url: '/ajax/delete-comment',
				      	data: {id: this_comment.data('id'), user_id: user_id},
				      	dataType:'json',
				        success: function( data ) {
				        	if(data == true)
				        	{
				        		this_comment.parents('.m_list_item').slideUp('fast', function(){
				        			$(this).remove();
				        		});
				        	}
				            	
				  	}
				});
		});

	 	$(this).find('.comment_form').on('submit', function(){

			var this_form = $(this);
			var this_type = this_form.data('type');
			var this_id = this_form.data('id');
			var comment_div = this_type + "-" + this_id;
			var my_comment = this_form.find("textarea[name='comment']").val();
			if(my_comment.length >1 && user_id.length >0)
			{

				$.ajax({
				        method:'post',
				        url: '/ajax/add-comment',
				      	data: this_form.serialize() + "&" + $.param({object_type:this_type, object_id: this_id, user_id: user_id}),
				      	dataType:'json',
				        success: function( data ) {
				        	if(data.result)
				        	{
				        		if(data.length>0)
				        		{
				        			this_box.find('.filler').hide();
				        		}
				        		this_form[0].reset();
				        		var c = {
				        			id: data.result,
				        			comment: my_comment.replace(/\r?\n/g, '<br />'),
				        			username: data.username,
				        			name: data.name,
				        			created: "",
				        			profile_pic: data.profile_pic,
				        			spoiler: 0
				        		}
				        		$('#'+ comment_div).append(comment_template(c));
				        	}
				            	
				  	}
				});
			}

			
			return false;
		});

		
		
	});

	function comment_template(data)
	{
		var delete_btn = '';
		
		if(data.spoiler == 1)
		{
			data.comment = "<span class='spoiler'>" + data.comment + "</span>";
		}

		if(data.username === username)
		{
			delete_btn = '<a href="javascript:;" class="delete_comment" data-id="'+ data.id+'"><i class="step fi-x" style="font-size:24px;color:#ccc;" ></i></a>';
		}
		var my_html = '<div class="m_list_item">\
			<div class="m_list_left">\
			<a href="/"  ><img  width="40" height="40" src="'+ data.profile_pic + '" ></a>\
			</div>\
			<div class="m_list_right">\
				<p><a href="/'+ data.username + '">' + data.name + '</a> ' + data.comment + '</p>\
				'+ delete_btn+'\
			</div>\
		</div>';


		return my_html;
	}
 	
 	return this;
    };
 
}( jQuery ));


$('.comment-section').commentify();