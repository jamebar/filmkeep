@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/feed.js') }}"></script>
<script src="{{ URL::asset('js/comments.js') }}"></script>
@stop

@section('content')
		@if (Session::has('flash_notice'))
			<div id="flash_notice" data-alert data-options="animation_speed:500;" class="alert-box ">{{ Session::get('flash_notice') }} <a href="#" class="close">&times;</a></div>
		@endif
		<style>
	   	body{
			background:#e8e8e8;
			
		}
		</style>
    
    
  
	<div class="row ">
		<div class="small-12 medium-8  columns ">
		
  		  <section id="feed" >
	        <div class="activity-feed">
	        	<div class="feed-padding feed-item">
		        	<h4 class="subheader">Activity Feed <small>You have <?php if(isset($friends)) echo count($friends);?> friends using FilmKeep</small></h4>
		        	
		        </div>
		     
		       <div id="activity-feed-items"></div>
		       <div class="feed-loader"><p>Loading feed</p></div>
		       <a href="javascript:;" class="button" style="display:none;" id="load-more">load more activity items</a>
		       </div> <!--end activity-feed -->
	        </section> 
	    </div>
	    
	</div>
   
  
    



	
@stop