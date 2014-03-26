@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/feed.js') }}"></script>
<script src="{{ URL::asset('js/comments.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.isotope.min.js') }}"></script>
@stop

@section('content')
		
		<style>
	   	body{
			 background:#f4e8d0 ;
			
		}
		</style>
    
    
  
	<div class="row ">
		<div class="small-12   columns ">
		
	  		<section id="feed" >
			        <div class="activity-feed">
				       <div id="activity-feed-items"></div>
				       <div class="feed-loader"><p>Loading feed</p></div>
				       <a href="javascript:;" class="button" style="display:none;" id="load-more">load more activity items</a>
				</div> <!--end activity-feed -->
		        </section> 
	    	</div>

	   
	</div>
   
  
    



	
@stop