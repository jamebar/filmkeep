
$(function(){
		var last_date = "";
		load_feed();
		$container = $('#activity-feed-items');
		//Initialize isotope
		$container.isotope({
		  // options
		  resizable: false, 
		  	itemSelector : '.feed-item',
		  	layoutMode : 'masonry',
		  	masonry: {
			    columnWidth: $container.width() / 2 
			  }
  			
		});
		
		$('#load-more').on('click',function(){
			load_feed();
		});
		
		function load_feed()
		{
			$('.feed-loader').show();
			$('.feed-loader').spin('flower','#ccc');
			
			$.ajax({
				type: "POST",
				url: '/ajax/get-feed',
				dataType: 'json',
				data:{last_date: last_date},
				success: function(data) { 
					$('.feed-loader').spin(false);
					$('.feed-loader').hide();
					
					last_date = data.last_date;
					var $newitems = $(data.items.join(''));
					
					//$('.comment-section').commentify();
					$('#load-more').css('display','block');
					$container.append($newitems).isotope( 'appended', $newitems );
					$('.trailer:not(.trailer-init)').trailer();
					$('.comment-section:not(.comment-init)').commentify();
					$('.comment-section').on('comments-added', function(){
						$container.isotope( 'reLayout');
						
					});
					$('.comment-section').on('comments-form-show', function(){
						$container.isotope( 'reLayout');
						
					});
				}

			});
		}
	// update columnWidth on window resize
$(window).smartresize(function(){
  $container.isotope({
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.width() / 2 }
  });
});	

	
});
