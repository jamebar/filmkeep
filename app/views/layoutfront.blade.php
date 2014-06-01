
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
  <link rel="stylesheet" href="{{ URL::asset('css/foundation.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/foundation-icons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu-positioning.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/jquery.nouislider.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom-theme/jquery-ui-1.10.3.custom.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom.css?nocache=<?php echo rand(100,10000);?>') }}">
  <link href='http://fonts.googleapis.com/css?family=Lato:400,700italic' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Volkhov:400,700italic' rel='stylesheet' type='text/css'>
  @show
  <script src="{{ URL::asset('js/vendor/custom.modernizr.js') }}"></script>
    <script>
        var username = "{{ $logged_in_user->username or ''}}";
    </script>
</head>
<body>


<div class="off-canvas-wrap @if(Auth::check() && $show_feed ) feed-show @endif">
  <div class="inner-wrap">

	<div id="header_all" >
		<div class="fixed header-bg">
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
							<a  href="javascript:;" data-dropdown='notif_list_large' class="notif_parent notif_large notif_top"> <i class="step fi-web size-26" style="font-size:26px;color:#f4e8d0;" ></i> @if(isset($new) && $new >0) <span class='notif notif_top_num'>{{ $new }}</span> @endif </a>
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
							<a href="{{ route('home') }}/{{ $logged_in_user->username }}">My Filmkeep</a>
						</li>
						

						<li class="has-form">
							<a class="button tiny radius" data-reveal-id="add-film" href="javascript:;"><i class="step fi-plus size-14" style="font-size:14px;color:#fff;" ></i> REVIEW</a>
						</li>
						<li>
							<div class="login-info">
								<a href="#" data-dropdown="login-info-menu" ><img  src="{{ $logged_in_user->profile_pic }}" width="30" height="30">
								<i class="step fi-widget " style="font-size:22px;color:#f4e8d0;" ></i></a>
								<div id="login-info-menu" data-dropdown-content class="f-dropdown ">
								  	<a href="/{{ $logged_in_user->username }}/watchlist"><i class="step fi-list-thumbnails " style="font-size:18px;color:#f38f7f;" ></i> Watchlist</a>
								  	<a href="{{ route('profile') }}"><i class="step fi-wrench " style="font-size:18px;color:#f38f7f;" ></i>  Settings</a>
								  	<a href="{{ $button['url'] }}"><i class="step fi-minus-circle " style="font-size:18px;color:#f38f7f;" ></i> {{ ucwords($button['text']) }}</a>
								  	
								  
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
						<img src="{{ URL::asset('img/filmkeep_logo_top.png')}}" style="float: left; margin-top: 7px; margin-left: 8px;" width="126" height="21"/>
					</div>
				 <div class="small-4 columns">
				     
				    @if (Auth::check())
				     <ul class="right inline-list">
				         <li>
				         <a  href="javascript:;" data-dropdown='notif_list' class="notif_parent notif_top"> <i class="step fi-web size-26" style="font-size:26px;color:#f4e8d0;" ></i> @if(isset($new) && $new >0) <span class='notif notif_top_num'>{{ $new }}</span> @endif </a>
				          
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
	<!-- check for login error flash var -->
    @if (Session::has('flash_error'))
        <div id="flash_error" data-alert data-options="animation_speed:500;" class="alert-box warning">{{ Session::get('flash_error') }} <a href="#" class="close">&times;</a></div>
    @endif

    @if ( count( $errors->all() ) > 0 )
    	<div id="flash_error" data-alert data-options="animation_speed:500;" class="alert-box warning">
       @foreach( $errors->all() as $error )

       		{{ $error }}
       @endforeach
        <a href="#" class="close">&times;</a></div>
    @endif

    @if (Session::has('flash_notice'))
        <div id="flash_notice" data-alert data-options="animation_speed:500;" class="alert-box ">{{ Session::get('flash_notice') }} <a href="#" class="close">&times;</a></div>
    @endif
	
	<div id="content">
		@yield('content')
	</div>

<!-- Footer -->

	<footer class="footer">
		<div class="row full-width">
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
		@if( $show_feed )
			@include('feed')
		@endif
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

		
		@include('add_film')

		<div class="tip small-12 columns">
	      		<div class="intercept-film"></div>              
		    	<div class="tip-line small-12 columns">
				<div class="tip-line-bg small-12 columns"></div>
			 	<div class="dot-con"><div class="film-dot"></div></div>
			</div>
		</div>

		@include('edit_film')
	  @endif
	</div> <!-- end inner wrap -->

	

	@include('reveals')

</div><!-- end off canvas wrap-->

<!-- <script src="http://code.jquery.com/jquery-1.9.1.js') }}"></script> -->
	<script>
		var user_reviews = "";
	</script>
	@section('scripts')
	<script src="{{ URL::asset('js/vendor/jquery.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery-ui-1.10.3.custom.min.js') }}"></script> 
	<script src="{{ URL::asset('js/foundation.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.hammer.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.nouislider.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/spin.min.js') }}"></script>
	
	@if(Auth::check())
	<script src="{{ URL::asset('js/vendor/jquery.nanoscroller.min.js') }}"></script>
	<script src="{{ URL::asset('js/add-film.js?nocache='.rand(100,10000) ) }}"></script>
	<script src="{{ URL::asset('js/edit-film.js?nocache='.rand(100,10000) ) }}"></script>
	<script src="{{ URL::asset('js/follow.js') }}"></script>
	<script src="{{ URL::asset('js/feed.js') }}"></script>
	<script src="{{ URL::asset('js/watchlist.js') }}"></script>
	@endif
	
	<script src="{{ URL::asset('js/vendor/jquery.spin.js') }}"></script>
	<script src="{{ URL::asset('js/trailer.js') }}"></script>
	<script src="{{ URL::asset('js/comments.js') }}"></script>
	@show
	<script>
	
	$(window).scroll(function(){
		var scrolltop = $(this).scrollTop();
		var maxscroll = 200;

		var myper = (scrolltop / maxscroll ) + .3;
		
		if(myper >1)
			myper = 1;


		$('.header-bg').css('background', 'rgba(50,50,50, ' +  myper +')');
		
		
	});


	var user_id = "{{ $logged_in_user->id or '' }}";
	
	$(document).foundation({
		reveal:{
			close_on_background_click: false,
			animation: 'fade',
		}
		
	});

	$(document).ready(function(){
		
		
		$.fn.spin.presets.flower = {
		  lines: 11,
		  length: 10,
		  width: 3,
		  radius: 5,
		  color: '#aaa'
		}
		
		/*
		*  Auto Close alert boxes
		*/
		window.setTimeout(function() {
		    $(".alert-box").fadeTo(500, 0).slideUp(500, function(){
		        $(this).remove(); 
		    });
		}, 3000);


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
			
			$('.nano').height( $(window).height() );
			

			$(".nano").nanoScroller({ 

				preventPageScrolling: true,
				alwaysVisible: true
			});
		}

		
		

	});

	
	
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
