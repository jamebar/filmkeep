(function( $ ) {
 
    $.fn.custom_type = function() {
 	
 	this.each(function() {
        	
 		var root = $(this);

 		$(this).find('form.custom-type-form').on('submit', function(){

 			$(this).find('a.add-type').trigger('click');
 			return false;
 		});

		$(this).find('a.add-type').on('click', function(){
			var type_name = $('.custom-type-form input[name="type_name"]').val();
			
			if(type_name.length >0)
			{
				$.ajax({
				        method:'post',
				        url: '/ajax/add-custom-type',
				      	data: {name: type_name},
				      	dataType:'json',
				        success: function( data ) {
				        	if(data.id)
				        	{
				        		$('.custom-type-form input[name="type_name"]').val('') ;
				        		

				        		$(typeTemplate(data)).appendTo('ul.custom-types').fadeIn('fast');
				        		$(document).foundation();
				        	}
				            	
				  	}
				});
			}
			
			return false;
		});

	 	$(this).find('ul.custom-types').on('click' , '.delete-type', function(){


	 		var this_item = $(this);
	 		var type_id = this_item.data('typeid');
	 		
	 		if(type_id)
	 		{
	 			$.ajax({
				        method:'post',
				        url: '/ajax/delete-custom-type',
				      	data: {id: type_id},
				      	dataType:'json',
				        success: function( data ) {
				        	
			        		this_item.parents('.c-item').slideUp();
				  	}
				});
	 		}
	 		

	 	});

		
		
	});

	function typeTemplate(data)
	{
		var my_html =  '<li class="c-item" style="display:none">\
		<span>' + data.label + '</span>\
		<div class="right">\
		<a href="javascript:;" class="edit-type" data-typeid="' + data.id + '"><i class="step fi-pencil size-36" style="font-size:22px;color:#178FE1;" ></i></a>\
		<a href="javascript:;" data-dropdown="drop' + data.id + '" class=" dropdown" ><i class="step fi-x size-36" style="font-size:22px;color:#178FE1;" ></i></a>\
		<ul id="drop' + data.id + '" data-dropdown-content class="f-dropdown">\
		  <li><a class="delete-type" data-typeid="' + data.id + '" href="javascript:;">Yes, delete <i class="step fi-trash " style="font-size:18px;color:#d50606;margin-left:1em" ></i></a></li>\
		  <li><a href="javascript:;">no, nevermind</a></li>\
		</ul>\
		</div>\
		</li>'

		return my_html;
	}

	
    };
 
}( jQuery ));


$('#custom-types').custom_type();