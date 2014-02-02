$(function(){
    var request_active = false;
    if(user_id.length >0){
    	$.get("/ajax/all-user-reviews", {user_id: user_id}, 
		function(data){
			user_reviews = data;
			
		},"json");
    }
    
    	
    
    /*
  	*
  	* Autocomplete for the title field
  	* Pulls search results from themoviedb.com
  	*/
	$( ".rtautocomplete" ).autocomplete({
	     appendTo: "#add-film",
	     autoFocus: true,
	     delay: 300,
		 source: function( request, response ) {
		     	$('#autocomplete_loader').spin('flower');
		    	$('#film_search_message').html("");
		    	$('#add_film_step2').hide();

			$.ajax({
			        method:'post',
			        url: '/ajax/search-tmdb',
			      	data: { query:request.term },
			      	dataType:'json',
			        success: function( data ) {
			            	
			        	if(data.results.length <1)
			        	{
			        		$('#autocomplete_loader').spin(false);
			        		$('#film_search_message').html("No results found");
			        	}

					response( $.map( data.results, function( item ) {

						if(item)
						{
							return {
								label: item.title + " ("+ item.release_date.split('-')[0] + ")" ,
								value: item.title  ,
								tmdb_id: item.id
							}
						}
			      
			   		}));
			  	}
			});
	      },
	      minLength: 2,
	      select: function( event, ui ) {
	          	$('#tmdb_id').val(ui.item.tmdb_id);
	          	$('#add_film_step2').show();
	          	init_sliders();
	          	request_active = false;
            
	      },
	      open: function() {
	      		$('#autocomplete_loader').spin(false);
	      },
	      close: function() {
	       
	      }
	     
	    
	});

	
	/*
	* Prevent form from submitting if keypress enter/return
	*/
	$('#add_film_form').bind("keyup keypress", function(e) {
	  var code = e.keyCode || e.which; 
	  if (code  == 13) {               
	    e.preventDefault();
	    return false;
	  }
	});

	/*
  	*
  	* Form submit handler
  	* Only submit if there is a tmdb_id set
  	*/
	$('#add_film_form').on('submit',function(){
	    
	    if($('#tmdb_id').val().length > 0 && !request_active)
	    {
	    	
	        
	        $('#rt_results').spin('flower');
	        
        	request_active = true;
        	$('#add-film .ajax-message').html('Adding your film, please wait...');
        
	        $.ajax({
	             	method:'post',
			url: '/ajax/create_review',
			data: $('#add_film_form').serialize(),
			dataType:'json',
			success: function( data ) {
				
				$('#rt_results').spin(false);
				//$('.ajax-message').html("Your film has been added. <a href='/"+username+"/r/"+data+"'>View it here</a>");
				window.location = '/'+username+'/r/'+data;
			}
              	});
	       
	        
	    }
	    return false;
	});

	function init_sliders()
	{
		/*
          	*
          	* Activate and show the sliders only if they aren't visible yet
          	*/
		if(!$('#add-film .noUiSlider:first').hasClass('noUi-target'))
		{
			
			// Initialise noUiSlider
			$('#add-film .noUiSlider').noUiSlider({
				range: [0,100],
				start: 50,
				handles: 1,
				connect: "lower",
				slide: function () {
					var r_type = $(this).data('rtype');
					var current_val = $(this).val();
					var closeMatches = "<div class='film-dot dot-current' style='left:"+ current_val +"%'></div>";
					var pos = $(this).parent().offset();
					$.each(user_reviews, function(index,val){

						var r = 0;
						if(val['ratings'][r_type] != "undefined")
						{
							r = val['ratings'][r_type];
						}

						closeMatches += "<div class='film-dot' style='left:"+ Math.floor(r) +"%'></div>";
						console.log("current:" + current_val + " = r:"+ r);
						if(Math.floor(current_val) == Math.floor(r)){
							$('.intercept-film').html(val['title']).show();
						}
						

					})
					$('.dot-con').html(closeMatches);
					$('.tip').css({
			                    position: "fixed",
			                    top: pos.top - $(window).scrollTop() - 70 + "px",
			                    left: 50 - $(this).val() + "%"
			                }).show();

					var c_pos = $('.dot-current').offset();
			                $('.intercept-film').css({
			                    position: "fixed",
			                    top: c_pos.top - $(window).scrollTop() - 70 + "px",
			                    left: (c_pos.left - 150) + "px"
			                })
					
				},
				set: function() {
					$('.tip').fadeOut("fast");
				}


			}).change( function (item,val) {

				$(this).parent().find('input').val( $(this).val());

			});

			
		}
	}
	var add_this = false;

	$('#activity-feed-items').on('click','.add-this', function(){
		add_this = true;
		$('#add-film').foundation('reveal', 'open');
		$('#add-film .rtautocomplete').val($(this).data('title'));
		$('#add-film #tmdb_id').val($(this).data('tmdbid'));
		$('#add-film h2').text('Add your review of "' + $(this).data('title') + '"');
		$('#add_film_step2').show();
		init_sliders();

		
	});

	$('#add-film').bind('opened', function(){
			if(add_this == false){
				$('.rtautocomplete').focus();
				
				$('#add-film h2').text($('#add-film h2').attr('alt'));
				$('#add-film .rtautocomplete').val("");
				$('#add_film_step2').hide();
			}
			$('.rec-con').empty();
			$('#recommend_values').val('');
			$('.recautocomplete').val('');
			add_this = false;
	});


	/*
  	*
  	* Autocomplete for the recommendation field
  	* Pulls search results from db
  	*/
	$( ".recautocomplete" ).autocomplete({
	     appendTo: "#add-film",
	     autoFocus: true,
	     delay: 300,
		 source: function( request, response ) {
		     

			$.ajax({
			        method:'post',
			        url: '/ajax/search_users',
			      	data: { q:request.term },
			      	dataType:'json',
			        success: function( data ) {
			            	
			        	if(data.length <1)
			        	{
			        		
			        	}

					response( $.map( data, function( item ) {

						if(item)
						{
							return {
								label: item.name ,
								value: item.name,
								user_id: item.id 
								
							}
						}
			      
			   		}));
			  	}
			});
	      },
	      minLength: 1,
	      select: function( event, ui ) {
	          	
	          	var c_val = $('#recommend_values').val();
	          	$('#recommend_values').val(c_val + ui.item.user_id + "," );
	          	$('.rec-con').append('<span id='+ ui.item.user_id + ' >'+ ui.item.value + ' <a href="javascript:;">x</a></span>');
	          	$('.recautocomplete').val('');
	          	$('.recautocomplete').focus();
	          	return false;
            
	      },
	      open: function() {
	      		
	      },
	      close: function() {
	       	$('.recautocomplete').focus();
	      }
	     
	    
	});

	$('.rec-con').on('click','span a', function(){
		var delete_id = $(this).parent().attr('id');
		var r_vals = $('#recommend_values').val().split(',');
		var index = r_vals.indexOf(delete_id);
		if (index > -1) {
		    r_vals.splice(index, 1);
		}
		$('#recommend_values').val(r_vals.join(','));
		$(this).parent().remove();
	});
});
