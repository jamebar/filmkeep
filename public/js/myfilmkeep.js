var contentModel;
var num_per_page = 24;
var current_page=0;
var total_items = 10;
var search_query = "";
var sort_dir = "desc";

	$(document).ready(function(){
		
		contentModel = new contentViewModel();
		ko.applyBindings(contentModel);
		contentModel.loadData();
		
		$('.my_pagination').pagination({
		        items: total_items,
		        itemsOnPage: num_per_page,
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

	
	function content_item(review_id,title,poster_path,slug) {
		this.review_id 		= ko.observable(review_id);
	    	this.title 		= ko.observable(title);
	    	this.poster_path 	= ko.observable(poster_path);
	    	this.slug 		= ko.observable(slug);
	};
	
	
	
	function contentViewModel()
	{
		var self = this;
		self.feedData = ko.observable();
		self.loadData = function(){
			$('.spinner').spin('flower');
			$.getJSON('/ajax/get_filtered_reviews' , {num:num_per_page, page_user_id: page_user_id, page:current_page, search_query: search_query, sort_dir: sort_dir}, function (data) {
				var items = new Array();
				total_items = data.total;
				$('.total').text(total_items);
				$.each(data.items,function(index,item){
					var c = new content_item(
						item.review_id,
						item.title,
						item.poster_path,
						item.slug
					
					);
					items.push(c);
				});
				self.feedData({items:items});
				$('.my_pagination').pagination('updateItems', total_items);
				if(total_items <= num_per_page){
					$('.my_pagination').hide();
				}
				$('.spinner').spin(false);
			});
		}
	}
