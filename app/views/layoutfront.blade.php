
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
  
  <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/foundation.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/foundation-icons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/mmenu-positioning.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/jquery.nouislider.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom-theme/jquery-ui-1.10.3.custom.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/custom.css?nocache=<?php echo rand(100,10000);?>') }}">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
  <script src="{{ URL::asset('js/vendor/custom.modernizr.js') }}"></script>
    <script>
        var username = "";
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
							<a  href="javascript:;" data-dropdown='notif_list_large' class="notif_parent notif_large notif_top"> <i class="step fi-web size-26" style="font-size:26px;color:#fff;" ></i> @if(isset($new) && $new >0) <span class='notif notif_top_num'>{{ $new }}</span></a> @endif
						</li>
						<div id="notif_list_large" class="f-dropdown content medium" data-dropdown-content>
							@if(isset($notifications))

							<h4><small>Notifications</small></h4>
							<?php foreach($notifications as $notif):?>

							<div class="m_list_item">
								<div class="m_list_left">
									<img  src="{{ $notif['profile_pic'] }}" >
								</div>
								<div class="m_list_right">
									@if($notif['notif_type'] === 'comments')

									<p>{{ $notif['name'] }} commented on</p>
									<a href="/{{  $notif['review_username'] }}/r/{{ $notif['id'] }}"  id="">{{ $notif['title'] }}</a>

									@elseif($notif['notif_type'] === 'recommendations')

									<p>{{ $notif['name'] }} recommends</p>
									<a href="/film/{{ $notif['film_id'] }}"  id="">{{ $notif['title'] }}</a>

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
							<a href="{{ route('home') }}/{{ Auth::user()->username }}">My Filmkeep</a>
						</li>
						

						<li class="has-form">
							<a class="button tiny" data-reveal-id="add-film" href="javascript:;"><i class="step fi-plus size-14" style="font-size:14px;color:#fff;" ></i> REVIEW</a>
						</li>
						<li>
							<div class="login-info">
								<a href="#" data-dropdown="login-info-menu" ><img  src="{{ Auth::user()->profile_pic }}" width="30" height="30">
								<i class="step fi-widget " style="font-size:22px;color:#888;" ></i></a>
								<div id="login-info-menu" data-dropdown-content class="f-dropdown ">
								  	<a href="/{{ Auth::user()->username }}/watchlist"><i class="step fi-list-thumbnails " style="font-size:18px;color:#178FE1;" ></i> Watchlist</a>
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
	          	
	             <a href="/" style="float: left; margin-top: 4px; margin-left: 8px;"><img src="{{ URL::asset('img/filmkeep_logo_top.png') }}" width="126" height="21"/></a>
	          </div>
	          <div class="small-4 columns">
	             
	            
	          </div>

	          <div id="notif_list" class="f-dropdown content small " data-dropdown-content>
		
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

<!-- <script src="http://code.jquery.com/jquery-1.9.1.js') }}"></script> -->

	<script src="{{ URL::asset('js/vendor/jquery.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery-ui-1.10.3.custom.min.js') }}"></script> 
	<script src="{{ URL::asset('js/foundation.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.hammer.min.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/jquery.nouislider.js') }}"></script> 
	<script src="{{ URL::asset('js/vendor/spin.min.js') }}"></script>
	<!--<script src="{{ URL::asset('js/add_film.js?nocache=<?php echo rand(100,10000);?> ') }}"></script>-->
	<script src="{{ URL::asset('js/watchlist.js') }}"></script>
	<script src="{{ URL::asset('js/vendor/jquery.spin.js') }}"></script>
	<script>
	
	var user_id = "";
	
	$(document).foundation({
		reveal:{
			close_on_background_click: false,
			
		}
		
		
	});

	</script>
</body>
</html>
