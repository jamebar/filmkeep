@extends('layoutfront')

@section('scripts')
@parent

@stop

@section('content')
		
	<style>
   	body{
	 background:#3f3f3f ;
	padding-top:0px;
	}
		
	
	.film_cover_bg{
	    background:url({{ DEFAULT_BACKGROUND_PIC }}) 0px 0px  no-repeat;
	    background-size:cover;
	   
	}
	.film_cover{
		min-height: 325px;
		padding: 120px 20px 30px;
		border-top: 1px solid #fff;
	}

	
	</style>
    
  	<div class="film_cover_bg">
	    	<div class="film_cover" >
		    <div class="row">
		        <div class="small-12 columns text-center light">
		           
				<h2>Keep your opinions to everyone</h2>
				<p>Rate. Recommend. Share. Compare. Discover.<br>New around here? <a href="{{ route('join') }}">Sign up</a>! Also, hello!</p>
				<p>or, <a href="{{ route('login') }}">login here</a></p>
		              
		        </div>
		    </div>
	    	</div>
	</div>
	<div class="full-width-section theme-beige" >
            <div class="row">
                <div class="small-12 medium-12  columns text-center">
                	
                </div>
            </div>
        </div>
   
  	<div class="full-width-section theme-red" >
            <div class="row">
                <div class="small-12 medium-12  columns">
                <h3 class="light">Strongest reviews of the week</h3>
                </div>
            </div>
        </div>
    
        <div class="full-width-section theme-orange" >
            <div class="row">
                <div class="small-12 medium-12  columns">
                	<h3 class="light">Films aren't always black or white.</h3>
			<p>They aren’t just good or bad, two stars or four, fresh or frozen. Movies are an escape. They’re two hours of our frighteningly short lives. They can affect you in deep and impactful ways, yet are so often reduced to a solitary, crowdsourced score as meaningless as the smiley face sticker you earned for your 1st grade art project.</p>

			<p>Is it really possible to round The Godfather to the nearest whole number? Are we not human?</p>

			<h3 class="light">Judge not. Evaluate yes.</h3>
			<p>We need a place for real ratings, from humans you can trust. A safe place, where movies are treated with respect. A place to keep the films we love and rate from becoming just another number.</p>

			<h3 class="light">We need to go deeper.</h3>
			<p>FilmKeep lets you delve into just what makes a film what it is — not with a meaningless number but a set of specific, customizable criteria that actually lets your friends know, at a glance, what you really think of a film. Rate, share, compare and discover — and keep it all right here.</p>

			<h3>FILMKEEP</h3>
			<p>Rate movies. Love film</p>

			<a href="" class="button">Let's do this</a>

                </div>
            </div>
        </div>


	
@stop