var contentModel;
var num_per_page = 12;
var current_page=0;
var total_items = 10;
var search_query = "";
var sort_dir = "desc";

//check for pagination
if(window.location.hash) {
  var hash = window.location.hash;
  current_page = hash.substr(hash.indexOf('-') +1) -1;
  
} 

	$(document).ready(function(){
		
		contentModel = new contentViewModel();
		ko.applyBindings(contentModel);
		contentModel.loadData();
		
		$('.my_pagination').pagination({
		        items: total_items,
		        itemsOnPage: num_per_page,
		        displayedPages: 3,
		        currentPage: current_page +1,
		        cssStyle: 'light-theme',
		        onPageClick:function(pageNumber, event){
		        	current_page = pageNumber -1;
		        	contentModel.loadData();
		        }
		});



		$('#search_myfilmkeep').on('keyup',function()
		{
			
				search_query = $(this).val();
				
				current_page = 1;
				$('.my_pagination').pagination('selectPage', current_page);
				$('.my_pagination').hide();
				if($(this).val() == "")
				{
					$('.my_pagination').show();	
				}
				contentModel.loadData();
			
		});

		$('#sort_dir').on('change',function(){
			sort_dir = $(this).val();
			contentModel.loadData();
		});
	});

	
	function content_item(review_id,title,poster_path,slug, created_at, rating) {
		var self = this;
		this.review_id 		= ko.observable(review_id);
	    	this.title 		= ko.observable(title);
	    	this.poster_path 	= ko.observable(poster_path);
	    	this.slug 		= ko.observable(slug);
	    	this.created_at		= ko.observable(created_at);
	    	this.rating 		= ko.observable(rating);

	    	this.rating = ko.computed(function(){
	    	
	    		var rating = 0;
	    		$.each(self.rating(), function(index,val)
	    		{
	    			
	    			if(val.rating_type == 2)
	    			{
	    				rating = val.rating;
	    				return;
	    			}
	    			
	    		});

	    		return rating;
	    	});
	    	//console.log('rating=' + this.rating());
	};
	
	
	
	function contentViewModel()
	{
		var self = this;
		self.feedData = ko.observable();
		self.loadData = function(){
			$('.spinner').spin('flower');
			$.getJSON('ajax/filtered-reviews' , {num:num_per_page, page_user_id: page_user_id, page:current_page, search_query: search_query, sort_dir: sort_dir}, function (data) {

				var items = new Array();
				total_items = data.total;
				$('.total').text(total_items);
				console.log(data.items);

				$.each(data.items,function(index,item){

					var c = new content_item(
						item.id,
						item.title,
						item.poster_path,
						item.slug,
						item.created_at,
						item.ratings
					
					);
					items.push(c);
				});
				self.feedData({items:items});
				$('.my_pagination').pagination('updateItems', total_items);
				if(total_items <= num_per_page){
					$('.my_pagination').hide();
				}
				$('.spinner').spin(false);
				
				if(user_reviews.length > 0)
				{
					//addRatingsLine();
				}
				
			});
		}
	}

	function addRatingsLine()
	{
		var con = $('.rating-line');
		var t = "";
		$.each(user_reviews, function(index, val)
		{

			t += '<span class="rating-line-dot" style="left:' + val.ratings[2] + '%"></span>';
		});

		con.prepend(t);
	}
