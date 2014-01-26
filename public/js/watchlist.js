$(function(){
	$( "#sortable" ).sortable({
		update: function( event, ui ) 
		{
			var sorted = $( "#sortable" ).sortable( "serialize", { } );
			$.ajax({
			    method:'post',
				url: '/ajax/sort_watchlist',
				data: sorted,
				dataType:'json',
				success: function( data ) {
					
					//console.log(data);
					}
			});
		},
		handle: ".handle"
	});

	$('#activity-feed-items').on('click','.add-remove-watchlist', function(){
		add_remove_watchlist_clicked($(this));
		return false;
	});
	
	$('.add-remove-watchlist').on('click', function(){
		add_remove_watchlist_clicked($(this));
		return false;
	});
	
	function add_remove_watchlist_clicked(context)
	{
		var film_id = context.data('film_id');
		var this_user_id = context.data('user_id');
		var this_item = context;
		var my_action = "add";
		if(this_item.hasClass('onlist'))
			my_action = "remove";
		
		$.ajax({
		    method:'post',
			url: '/ajax/add_remove_watchlist',
			data: { film_id: film_id , user_id: this_user_id, action:my_action },
			dataType:'json',
			success: function( data ) {
				this_item.toggleClass('onlist');
				}
		});
	}

	$('.my-watchlist').on('click','.remove-from-watchlist', function(){
		var w_id = $(this).data('id');
		
		var this_item = $(this);
		
		$.ajax({
		    method:'post',
			url: '/ajax/remove_from_watchlist',
			data: { id: w_id  },
			dataType:'json',
			success: function( data ) {
				this_item.parents('.list_item').remove();
				}
		});
		
		return false;
	});
	
	
		
    
    /*
  	*
  	* Autocomplete for the title field
  	* Pulls search results from themoviedb.com
  	*/
	$( ".wlautocomplete" ).autocomplete({
	     autoFocus: true,
	     delay: 300,
		 source: function( request, response ) {
		     
		    	
		    	$('#watchlist_search_loader').spin('flower');
		    	$('#film_search_message').html("");
		    	

			$.ajax({
			        method:'post',
			        url: '/ajax/search_tmdb',
			      	data: { query:request.term },
			      	dataType:'json',
			        success: function( data ) {
			            	
			        	if(data.results.length <1)
			        	{
			        		$('#watchlist_search_loader').spin(false);
			        		$('#watchlist_search_message').html("No results found").show();
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
	          	//$('#tmdb_id').val(ui.item.tmdb_id);
	         
	          $.ajax({
			        method:'post',
			        url: '/ajax/add_watchlist_search',
			      	data: { tmdb_id: ui.item.tmdb_id, user_id: user_id },
			      	dataType:'json',
			        success: function( data ) {
			        	
			        	if(data == "duplicate")
			        	{
			        		$('#watchlist_search_message').html("<div class='alert-box alert'>This film is already on your watchlist</div>").slideDown("fast");
			        	}	
			        	else
			        	{
			        		add_film_to_list(data);
				        	$('#watchlist_search_message').html("<div class='alert-box success'>" + data.title + " has been added.</div>").slideDown("fast");
				        	
			        	}

			        	setTimeout(function() 
			        	{
					 $('#watchlist_search_message').slideUp('slow');
					
					}, 1000 );
			        	
			        }
			  });
	          	
	      },
	      open: function() {
	      		$('#watchlist_search_loader').spin(false);
	      },
	      close: function() {
	       
	      }
	     
	    
	});
	
	function add_film_to_list(data)
	{
		var new_f = '<li id="list_'+ data.watchlist_id +'"  class="list_item">\
		<a href="/film/'+ data.film_id + '-'+ data.title +'"><img  class="left" src="' + data.poster_path + '" /></a>\
            <div class="show-for-small watchlist-right">\
                <p>'+ data.title +'</p>\
                <a href="javascript:;" data-id="'+ data.watchlist_id +'" title="remove from watchlist" class="button remove-from-watchlist tiny"><i class="step fi-minus-circle  size-14" style="font-size:14px;color:#fff;"></i> remove</a>\
            </div>\
            <div class="watchlist_bottom_bar hide-for-small">\
            <span ><a href="javascript:;" class="button  left tiny handle "  title="drag to re-order"><i class=" step fi-thumbnails size-14" style="font-size:14px;color:#fff;"></i> </a></span>\
                <a href="javascript:;" data-id="'+ data.watchlist_id +'" title="remove from watchlist" class="button remove-from-watchlist tiny"><i class="step fi-minus-circle  size-14" style="font-size:14px;color:#fff;"></i></a>\
            </div>\
            </li>';
        $('.my-watchlist').append(new_f);
	}
	
});

