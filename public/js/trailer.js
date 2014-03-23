(function( $ ) {
 
    $.fn.trailer = function() {
 	
    	
	this.on('click', function(){


		var root = $(this);
		var tmdb_id = root.attr('id');

		

		var win_width = $(window).width();
		var padding = 30 * 2;
		var max_width = 640;
		var max_height = 360;
		var frame_width = win_width * .8;
		var frame_height =  ( frame_width / 1.77 );
		var margin_left = -(frame_width + padding)/2;

		if(win_width > 800)
		{
			frame_width = max_width;
			frame_height = max_height;
			margin_left = -(frame_width + padding)/2;
		}

		if(win_width < 768)
		{
			frame_width = win_width * .9;
			frame_height = frame_width / 1.77;
			padding = win_width * .1;
			margin_left = 0;
			$('#myTrailer').css({'paddingLeft': win_width * .1 /2, 'paddingRight' : win_width * .1 /2});
		}

		$('#myTrailer').css({'width': frame_width + padding, 'marginLeft' : margin_left});
		$('#myTrailer').foundation('reveal', 'open');

		$.ajax({
			type: "POST",
			url: '/ajax/film-trailer',
			dataType: 'json',
			data: {tmdb_id: tmdb_id},

			success: function(data) { 
				
				

				if(data.youtube.length > 0)
				{
					$('#myTrailer span').html('<iframe width="'+frame_width+'" height="'+ frame_height +'" src="//www.youtube.com/embed/'+data.youtube[0].source+'" frameborder="0" allowfullscreen></iframe>');

				}

				
				/*spin_con.spin(false);
				if(data.youtube.length > 0)
				{

					con.slideDown('fast', function(){
						$('html, body').animate({
						        scrollTop: con.offset().top - 50
						    }, 1000, function(){
						    	con.html('<hr><a href="javascript:;" style="margin-bottom:1em;" class="right close-trailer"><i class="step fi-x" style="font-size:20px;color:#aaa;"></i> close trailer</a><iframe width="'+frame_width+'" height="'+ frame_height +'" src="//www.youtube.com/embed/'+data.youtube[0].source+'" frameborder="0" allowfullscreen></iframe>');
						    });
						

					});
					
				}*/
				
			}

		});
	});
    	
 	
		
		
	

	this.addClass('trailer-init');
 	
 	return this;
    };
 
}( jQuery ));

$('.trailer').trailer();
