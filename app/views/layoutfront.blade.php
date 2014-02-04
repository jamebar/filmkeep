
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" 	/>

  <title>{{$page_title or ""}} : FilmKeep</title>

  <!-- Included CSS Files -->
  @section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/foundation.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/foundation-icons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu-positioning.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/jquery.nouislider.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom-theme/jquery-ui-1.10.3.custom.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom.css?nocache=<?php echo rand(100,10000);?>') }}">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
  @show
  <script src="{{ URL::asset('js/vendor/custom.modernizr.js') }}"></script>
    <script>
        var username = "{{ $logged_in_user->username or ''}}";
    </script>
</head>
<body>
<div class="off-canvas-wrap">
  <div class="inner-wrap">

	<div id="header_all" >
		<div class="fixed">
		<div class="contain-to-grid sticky">
	  		<nav class="top-bar hide-for-small" >
	  			<ul class="title-area">
			      <!-- Title Area -->
			      
			      <li class="name">
			        <h1>
			          <a href="{{ route('home') }}">
			            <img width="170" src="{{ URL::asset('img/filmkeep_logo_top.png')}}"/>
			          </a>
			        </h1>
			      </li>
			    </ul>
				
				  
			  	<section class="top-bar-section" style="left: 0%;">
			      <!-- Right Nav Section -->
					<ul class="right">
					@if (Auth::check())
						<li>
							<a  href="javascript:;" data-dropdown='notif_list_large' class="notif_parent notif_large notif_top"> <i class="step fi-web size-26" style="font-size:26px;color:#fff;" ></i> @if(isset($new) && $new >0) <span class='notif notif_top_num'>{{ $new }}</span> @endif </a>
						</li>
						<div id="notif_list_large" class="f-dropdown content medium" data-dropdown-content>
							@if(isset($notifications))

							<h4><small>Notifications</small></h4>
							@foreach($notifications as $notif)

							<div class="m_list_item">
								<div class="m_list_left">
									<img  width="50" height="50" src="{{ $notif->profile_pic or DEFAULT_PROFILE_PIC }}" />
								</div>
								<div class="m_list_right">
									@if($notif->notif_type === 'comments')

									<p>{{ $notif->name }} commented on</p>
									<a href="{{ url('/r/'.$notif->id) }}" >{{ $notif->title }}</a>

									@elseif($notif->notif_type === 'recommendations')

									<p>{{ $notif->name }} recommends</p>
									<a href="/film/{{ $notif->film_id }}"  >{{ $notif->title }}</a>

									@endif
								</div>
							</div>

							@endforeach
							@endif
						</div>  
						<li >
							<a href="{{ route('home') }}">Feed</a>
						</li>
						<li >
							<a href="{{ route('home') }}/{{ $logged_in_user->username }}">My Filmkeep</a>
						</li>
						

						<li class="has-form">
							<a class="button tiny" data-reveal-id="add-film" href="javascript:;"><i class="step fi-plus size-14" style="font-size:14px;color:#fff;" ></i> REVIEW</a>
						</li>
						<li>
							<div class="login-info">
								<a href="#" data-dropdown="login-info-menu" ><img  src="{{ $logged_in_user->profile_pic }}" width="30" height="30">
								<i class="step fi-widget " style="font-size:22px;color:#888;" ></i></a>
								<div id="login-info-menu" data-dropdown-content class="f-dropdown ">
								  	<a href="/{{ $logged_in_user->username }}/watchlist"><i class="step fi-list-thumbnails " style="font-size:18px;color:#178FE1;" ></i> Watchlist</a>
								  	<a href="{{ route('profile') }}">Edit profile</a>
								  	<a href="{{ $button['url'] }}"><i class="step fi-minus-circle " style="font-size:18px;color:#178FE1;" ></i> {{ ucwords($button['text']) }}</a>
								  	
								  
								</div>
							</div>
						</li>
						@else
						<li>

							<a class="button tiny" href="{{ $button['url'] }}">{{ $button['text'] }} </a>
						</li> 

						@endif


						 
					</ul>
			    	</section>
	   		 </nav>
		</div>
		<section class="show-for-small">
			<header>
				<div class="row">
					<div class="small-8 columns">
						@if (Auth::check())
						<a class="left-off-canvas-toggle"><i class="step fi-list size-36" style="font-size:28px;color:#fff; float:left" ></i></a> 
						@endif
						<a href="/" style="float: left; margin-top: 4px; margin-left: 8px;"><img src="{{ URL::asset('img/filmkeep_logo_top.png')}}" width="126" height="21"/></a>
					</div>
				 <div class="small-4 columns">
				     
				    @if (Auth::check())
				     <ul class="right inline-list">
				         <li>
				         <a  href="javascript:;" data-dropdown='notif_list' class="notif_parent notif_top"> <i class="step fi-web size-26" style="font-size:26px;color:#fff;" ></i> @if(isset($new) && $new >0) <span class='notif notif_top_num'>{{ $new }}</span> @endif </a>
				          
				         </li>
				         <li> <a href="javascript:;" data-reveal-id="add-film"> <i class="step fi-plus size-36" style="font-size:28px;color:#fff;" ></i></a></li>
				         
				     </ul>
				     
				      
				    @endif
				 </div>

				  <div id="notif_list" class="f-dropdown content small " data-dropdown-content>
					@if(isset($notifications))

					<h4><small>Notifications</small></h4>
					@foreach($notifications as $notif)

					<div class="m_list_item">
						<div class="m_list_left">
							<img  width="50" height="50" src="{{ $notif->profile_pic or DEFAULT_PROFILE_PIC }}" />
						</div>
						<div class="m_list_right">
							@if($notif->notif_type === 'comments')

							<p>{{ $notif->name }} commented on</p>
							<a href="{{ url('/r/'.$notif->id) }}" >{{ $notif->title }}</a>

							@elseif($notif->notif_type === 'recommendations')

							<p>{{ $notif->name }} recommends</p>
							<a href="/film/{{ $notif->film_id }}"  >{{ $notif->title }}</a>

							@endif
						</div>
					</div>

					@endforeach
					@endif
				</div>  
				</div>
			</header>
		</section><!-- End Header and Nav --> 
	    </div>
	</div><!-- end header_all -->
	
	
@yield('content')

<!-- Footer -->

	<footer class="footer">
	<div class="row">
		 <div class="large-12 columns">
			
			<div class="row">
			  <div class="large-6 columns">
			  <ul class="inline-list">
			  <li><a href="/p/about">ABOUT</a></li>
			  <li><a href="/p/support">FEEDBACK</a></li>
			  <li><a href="/p/faq">FAQS</a></li>
			  <li><a href="/p/blog">BLOG</a></li>
			  </ul>
				<p>© FilmKeep 2013</p>
			  </div>
			  <div class="large-3 columns">
				
			  </div>
			  <div class="large-3 columns">
				
			  </div>

			  
		 </div>
	  </div>
	</footer>
<a class="exit-off-canvas"></a>

@if (Auth::check()) 
	
	<aside id="main-menu" class="left-off-canvas-menu">
	  <ul class="off-canvas-list">
		<li>
		  <a href="{{ route('home') }}"><i class="step fi-home size-24" style="font-size:24px;color:#aaa;" ></i>  &nbsp;Home</a>
		</li>
		<li>
		  <a href="{{ route('home') }}/{{ $logged_in_user->username }}"><i class="step fi-video size-24" style="font-size:24px;color:#aaa;" ></i> &nbsp;My Filmkeep</a>
		</li>
		<li>
		  <a href="{{ route('home') }}/{{ $logged_in_user->username }}/watchlist"><i class="step fi-list size-24" style="font-size:24px;color:#aaa;" ></i> &nbsp;My Watchlist</a>
		</li>
		
		<li>
		  <a href="{{ $button['url'] }}"><i class="step fi-minus-circle size-24" style="font-size:24px;color:#aaa;" ></i> &nbsp;{{  $button['text'] }}</a>
		</li>
	  </ul>
	</aside>

	
	<section id="add-film"  class="expand reveal-modal" data-reveal>
	  <div class="row">
		  <div class="small-12 columns">
				<h2 alt="Add a film review">Add a film review</h2>
				
		  </div>
	  </div>
	  
	  <form id="add_film_form" class="custom">
	  <div style="height:10px"></div>
		<div class="row">
		  <div class="small-12 columns " id="film_title">
			<input type="text" name="title" class="rtautocomplete"  placeholder="Start typing film title">
			<input type="hidden" name="tmdb_id" id="tmdb_id" value=""/>
			<input type="hidden" name="user_id" value="{{ $logged_in_user->id }}"/>
			<div id="autocomplete_loader" class="small-12" ></div>
			<div id="film_search_message" class="small-12" ></div>
		  </div>
		  
		  <div id="add_film_step2" style="display:none;">
			  <div class="small-12 columns">
				<label>When did you watch it?</label>
				<select name="date_watched" class="select-block">
					<option value="Just recently" selected>Just recently</option>
					<option value="Sometime this year">Sometime this year</option>
					<option value="Last year">Last year</option>
					<option value="Several years ago">Several years ago</option>
				</select>
			  </div>
			  <div class="small-12 columns">
				  <label>Where did you see it?</label>
				  <select name="source" value="Choose" class="select-block">
					<option value="theater">Theater</option>
					<option value="dvd">DVD</option>
					<option value="netflix">Netflix</option>
					<option value="amazon">Amazon</option>
					<option value="digital rental" >Digital Rental</option> 
					<option value="tv" >On TV</option> 
					<option value="other" >Other</option>  
				  </select>
			  </div>
			  <div class="small-12 columns">
			  <label for="own_checkbox">
			    <input name="own" type="checkbox" id="own_checkbox" >
			    <span class="custom checkbox"></span> Do you own it?
			  </label>
				
			  </div>
			  @if (isset($rating_types))  
					@foreach($rating_types as $r)
						 @if ($r->id !== '3')
							  <div class="small-12 columns">
								<label class="show-for-medium-up"><?php 
								
								if(strpos($r->label, '|') >-1){
									$l = explode("|",$r->label);
									echo $l[0]."<span class='label-right'>".$l[1]."</span>";
								}else {
									echo $r->label;  
								}?></label>
								<label class="show-for-small"><?php 
								
								if(strpos($r->label_short, '|') >-1){
									$l = explode("|",$r->label_short);
									echo $l[0]."<span class='label-right'>".$l[1]."</span>";
								}else {
									echo $r->label_short; 
								}?></label>
								<div class="noUiSlider" data-rtype="{{ $r->id }}" name="rating[{{$r->id }}]"></div>
								<input name="rating[{{ $r->id }}]" type="hidden" value="50" >

							  </div>
						  @endif
						  
			   		@endforeach        
			   @endif
			   <div class="small-12 columns">
			  <label for="hide_checkbox">
			    <input name="hide" type="checkbox" id="hide_checkbox" >
			    <span class="custom checkbox"></span> Hide from feed? <a data-options="disable-for-touch:true" data-tooltip class='has-tip ' title="If checked, your review will not appear in your friends' feed but will still be visible in your filmkeep"><i class="step fi-info size-36" style="font-size:22px;color:#178FE1;" ></i></a>
			  </label>
				
			  </div>
			   <div class="small-12 columns">
				  <label>Comments (AKA, your mini review)</label> 
				  <textarea style="height:8em;" rows="4"  name="comments" class=""></textarea>
			   </div>
			   
			    <div class="small-12 columns rec-input" id="film_rec">
			    	<label>Recommend this film to a friend ( <em>enter nothing to skip</em> )</label> 
				<input type="text" name="recommend_type" class="recautocomplete"  placeholder="Type a friend's name">
				<input type="hidden" name="recommend" id="recommend_values" value="">
				<div class="rec-con"></div>
			</div>
			  
			   <div class="small-12 columns">
				   <input type="submit" id="submit_add_film" class="large button expand" value="Add Film"/>
			   </div>
			   <div class="small-12 columns" id="rt_results">
				 <p class="ajax-message">Watch this space after you click "Add Film"</p>
			   </div>
			</div><!-- end add_film_step2 -->
			
	  </div>
	  </form>
	  <a class="close-reveal-modal">&#215;</a>
	</section>
	<div class="tip small-12 columns">
      		<div class="intercept-film"></div>              
	    	<div class="tip-line small-12 columns">
			<div class="tip-line-bg small-12 columns"></div>
		 	<div class="dot-con"><div class="film-dot"></div></div>
		</div>
	</div>
	@include('edit_film')
  @endif
</div>
</div><!-- end off canvas wrap-->

<!-- <script src="http://code.jquery.com/jquery-1.9.1.js') }}"></script> -->
	@section('scripts')
	<script src="{{ URL::asset('js/vendor/jquery.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery-ui-1.10.3.custom.min.js') }}"></script> 
	<script src="{{ URL::asset('js/foundation.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.hammer.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.nouislider.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/spin.min.js') }}"></script>
	<script src="{{ URL::asset('js/add-film.js?nocache='.rand(100,10000) ) }}"></script>
	@if(Auth::check())
	<script src="{{ URL::asset('js/edit-film.js?nocache='.rand(100,10000) ) }}"></script>
	<script src="{{ URL::asset('js/follow.js') }}"></script>
	@endif
	<script src="{{ URL::asset('js/watchlist.js') }}"></script>
	<script src="{{ URL::asset('js/vendor/jquery.spin.js') }}"></script>
	@show
	<script>
	
	var user_id = "{{ $logged_in_user->id or '' }}";
	
	$(document).foundation({
		reveal:{
			close_on_background_click: false,
			
		}
		
		
	});

	$(document).ready(function(){
		var user_reviews = "";
		
		$.fn.spin.presets.flower = {
		  lines: 11,
		  length: 10,
		  width: 3,
		  radius: 5,
		  color: '#aaa'
		}
		

		/*
		* Clear Notifications when viewed
		*/
		$('.notif_top').on('click',function(){
			
			if($('.notif').length>0)
			{
				$.ajax({
					type: "POST",
					url: '/ajax/clear-notifications',
					dataType: 'json',
					data: {user_id: user_id},

					success: function(data) { 
						if(data.result === 'success')
						{
							$('.notif_top_num').remove();
						}
						
					}

				});
			}

			
		});

		/*
		* Initialize scroll bar
		*/

		if ( $.isFunction($.fn.nanoScroller) ) {
			var num_c = $('.nano .content').children().length;
			if(num_c <4)
			{
				$('.nano').height(num_c * 90);
			}

			$(".nano").nanoScroller({ 

				preventPageScrolling: true,
				alwaysVisible: true
			});
		}

		


		/*
		* Load the trailer in the feed via ajax from tmdb.com 
		*/
		$('#activity-feed-items').on('click','.load-trailer', function(){
			loadTrailer($(this));
			return false;
		});
		
		$(".load-trailer").on('click',function(){
			loadTrailer($(this));
			return false;
		});
		
		function loadTrailer(context){
			
			var tmdb_id = context.attr('id');

			var con = context.parent().find(".trailer-con");
			if(con.length <1){
				con = $('.trailer-con');
			}
			var frame_width = con.width();
			var frame_height = frame_width/1.7;
			con.height(frame_height+80);
			
			if (con.find('iframe').length <1){
				var spin_con = con.parent();
				spin_con.spin('flower');
			
				$.ajax({
					type: "POST",
					url: '/ajax/film-trailer',
					dataType: 'json',
					data: {tmdb_id: tmdb_id},

					success: function(data) { 

						spin_con.spin(false);
						if(data.youtube.length > 0)
						{

							con.slideDown('fast', function(){
								$('html, body').animate({
								        scrollTop: con.offset().top - 50
								    }, 1000, function(){
								    	con.html('<hr><a href="javascript:;" style="margin-bottom:1em;" class="right close-trailer"><i class="step fi-x" style="font-size:20px;color:#aaa;"></i> close trailer</a><iframe width="'+frame_width+'" height="'+ frame_height +'" src="//www.youtube.com/embed/'+data.youtube[0].source+'" frameborder="0" allowfullscreen></iframe>');
								    });
								

							});
							
						}
						
					}

				});
			}else{
				con.slideDown('fast', function(){
					$('html, body').animate({
					        scrollTop: con.offset().top - 50
					    }, 1000);
				});
			}

			
		};

	});

	$('.row').on('click','.close-trailer',function(){
		$(this).parents('.trailer-con').slideUp('fast');
		return false;
	})
	
	var compare_num = 1;
	
	$(function(){
		$('.compare').on('click',function(){
			
			var t_con = $(this).parent();
			t_con.spin('flower');
			
			$.ajax({
				type: "POST",
				url: '/ajax/get_review',
				dataType: 'json',
				data:{id:$(this).attr('id')},
				success: function(data) { 

					t_con.spin(false);

					$('.ratings').each(function(index,item){
						for(var i = 0, m=null;i<data.ratings.length;i++)
						{
							if(data.ratings[i].type_id == $(this).data('typeid'))
							{
								m = data.ratings[i];
							}
						}
						
						var t = '<div class="progress compare'+compare_num+' radius"><span class="meter" style="width: '+m.rating+'%;"></span></div>';
						$(this).append(t);
					});

					compare_num++;
				}

			});

			return false; 
		});
	});

	</script>
</body>
</html>
