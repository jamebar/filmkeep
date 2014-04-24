$(function(){
	var request_running = false;
	
	$('#activity-feed-items').on('click','.edit-review', function(){
		edit_clicked($(this));
        return false;
	});
	
    $('.edit-review').on('click', function(){
			edit_clicked($(this));
            return false;
    });

	function edit_clicked(context){
		if (request_running) { // don't do anything if an AJAX request is pending
			    return;
			}
		request_running = true;
         $.ajax({
            method:'post',
            url: '/ajax/get-review',
            data: {id:context.data('id')},
            dataType:'json',
            success: function( data ) {
            //tmdb_spinner.stop();
                parse_review(data);
                request_running = false;
            }
          });
	}
    function parse_review(data)
    {
        
        $('#edit-film h2').html('Edit your review of "'+ data['title'] + '"');
        $('#edit_film_form #review_id').val(data['id']);
        $("#edit_film_form input[name='user_id']").val(user_id);

        var selectValues = new Array('Just recently', "Sometime this year", "Last year", "Several years ago");
        var date_select = $("#edit_film_form select[name='date_watched']");
        date_select.empty();
        $.each(selectValues, function(key, value) {   

             date_select
                 .append($("<option></option>")
                 .attr("value",value)
                 .text(value)); 
        });
        date_select.val(data['date_string']);

        $('#edit-film').foundation('reveal', 'open');
        
        

        var r_text = "";
        $.each(data['ratings'], function(index, val){
            if(val['type_id'] != null)
            {
                var v_rating = (val['rating'] === null) ? "" : val['rating'];
                var v_rating_id = (val['rating_id'] === null) ? "" : val['rating_id'];

                var label = val['label'];
                var label_short = val['label_short'];

                if(val['label'].indexOf('|') >-1)
                {
                    var s = label.split('|');
                    label = s[0] + "<span class='label-right'>" + s[1] + "</span>";
                }
                if(val['label_short'].indexOf('|') >-1)
                {
                    var s = label_short.split('|');
                    label_short = s[0] + "<span class='label-right'>" + s[1] + "</span>";
                }

                if(val['rating']===null)
                {
                    r_text+='<div class="small-12 columns  not-yet-rated">';
                    r_text+='<div class="new-rating">Not yet rated</div>';
                }else{
                    r_text+='<div class="small-12 columns">';
                }
                r_text += '<label class="show-for-medium-up">'+ label+'</label>\
                            <label class="show-for-small">'+ label_short+'</label>\
                            <div class="noUiSlider" data-start="'+ v_rating+'" data-rtype="'+ val['type_id']+'" ></div>\
                            <input name="rating['+ v_rating_id + '-'+ val['type_id'] +']" type="hidden" value="'+ v_rating+'" >\
                            </div>';
            }
            
            
        });
        $('.edit-ratings').html(r_text);


        $("#edit_film_form textarea[name='comments']").val(data['comments']);
        start_sliders();
    }

    function start_sliders()
    {
        // Initialise noUiSlider
        $('#edit-film .noUiSlider').noUiSlider({
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
                    //console.log("current:" + current_val + " = r:"+ r);
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

        $("#edit-film .noUiSlider").each(function(e){
            $(this).val($(this).data('start'));
            
        });

    }
    

    /*
    *
    * Form submit handler
    * Only submit if there is a tmdb_id set
    */
    $('#edit_film_form').on('submit',function(){
        
        
           // var submit_loader_con = document.getElementById('edit_results');
            //tmdb_spinner.spin(submit_loader_con); 
            $('#edit-film .ajax-message').html('Updating your review, please wait...');
            
            $.ajax({
                    method:'post',
                url: '/ajax/update-review',
                data: $('#edit_film_form').serialize(),
                dataType:'json',
                success: function( data ) {
                //tmdb_spinner.stop();
                    location.reload();
                }
              });
       
        return false;
    });
});

