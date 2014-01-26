
$(function(){
		var last_date = "";
		load_feed();
		
		
		$('#load-more').on('click',function(){
			load_feed();
		});
		
		function load_feed()
		{
			$('.feed-loader').show();
			$('.feed-loader').spin('flower','#ccc');
			
			$.ajax({
				type: "POST",
				url: '/ajax/get_feed',
				dataType: 'json',
				data:{last_date: last_date},
				success: function(data) { 
					$('.feed-loader').spin(false);
					$('.feed-loader').hide();
					
					last_date = data.last_date;
					$("<div />").html(data.items.join('')).appendTo('#activity-feed-items').find('.comment-section').commentify();
					
					//$('.comment-section').commentify();
					$('#load-more').css('display','block');
				}

			});
		}
		

	
});
