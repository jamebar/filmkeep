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
				        		$('.custom-type-form input[name="type_name"]').val('');
				        		

				        		$(typeTemplate(data)).appendTo('ul.custom-types').fadeIn('fast');
				        		$(document).foundation();
				        	}
				            	
				  	}
				});
			}
			
			return false;
		});

		$(this).find('ul.custom-types').on('click' , '.edit-type', function(){


	 		var this_item = $(this);
	 		var type_id = this_item.data('typeid');
	 		
	 		if(type_id)
	 		{
		 		//close any open forms
		 		$('.c-item').each(function(){

		 			var val = $(this);

		 			val.find('span').html( val.find('form').data('value'));
		 			val.find('.custom_type_controls').show();
		 		});

	 		
	 			var c_item = this_item.parents('.c-item');
	 			var c_value = c_item.find('span').text();

	 			var ht = "<div class='row'>\
	 				<form  data-value='" + c_value + "' id='update-custom-type' ><div class='medium-8 columns'>\
	 				<input type='text' name='type_name' value='" + c_value + "' />\
	 				<input type='hidden' name='type_id' value='" + this_item.data('typeid') + "' />\
	 				</div>\
	 				<div class='medium-4 columns'>\
	 				<input type='submit' class='custom_type_save button tiny' value='save'/>\
	 				</div></form></div>";
	 			c_item.find('span').html( ht );
	 			c_item.find('.custom_type_controls').hide();
	 			c_item.find(('form#update-custom-type input[name="type_name"]')).focus();

	 			//capture the form on submit handler, trigger a click on the save button
	 			$('form#update-custom-type').on('submit', function(){

		 			var c_item = $(this).parents('.c-item');
	 				var type_name = $('form#update-custom-type input[name="type_name"]').val();
	 				var type_id = $('form#update-custom-type input[name="type_id"]').val();


	 				$.ajax({
					        method:'post',
					        url: '/ajax/update-custom-type',
					      	data: {name: type_name, id: type_id},
					      	dataType:'json',
					        success: function( data ) {
					        	if(data)
					        	{
					        		c_item.find('span').html( type_name );
		 						c_item.find('.custom_type_controls').show();
					        		
					        		//$(document).foundation();
					        	}
					            	
					  	}
					});

		 			return false;
		 		});

	 			

	 		}
	 		

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