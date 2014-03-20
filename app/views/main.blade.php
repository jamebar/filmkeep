@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/feed.js') }}"></script>
<script src="{{ URL::asset('js/comments.js') }}"></script>
@stop

@section('content')
		
		<style>
	   	body{
			 background:#f4e8d0 url({{ DEFAULT_BACKGROUND_PIC }}) 0px 0px  no-repeat;
    background-size:cover;
			
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
	    <div class="medium-4  columns remove-left-gutter show-for-medium-up">
	    	<div class="rmg">
		    	<div class="rm watchlist">
		    		<h5><a href="/{{ $logged_in_user['username'] }}/watchlist">My Watchlist</a></h5>
		    		@if(count($watchlist)<1):?>
		    			<p style="color:#10527f;">You haven't added any movies to your watchlist</p>
		    		@else
		    		
		    			<ul class="medium-block-grid-3">
					@foreach($watchlist as $w)
						<li>
	    					<a href="/film/{{ $w->film_id."-".Str::slug($w->title) }}"><img  class="left" src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][1].$w->poster_path }}" /></a>
	    					
	    					
	    					</li>
					
					
					@endforeach 
					</ul>
					<a href="/{{ $logged_in_user['username'] }}/watchlist">view full watchlist</a>
				@endif
		    		
		    	</div>
		    	@if(isset($friends))
		    	<div class="rm">
		    		<h5>Friends using FilmKeep</h5>
		    		<div class="nano">
		    			<div class="content">
			    		<?php foreach ($friends as $friend):  if(isset($friend['username']) ):?>
			    			
			    			<div class="m_list_item">
				    			<div class="m_list_left">
				    				<a href="/<?php echo $friend['username'];?>"  ><img  src="http://graph.facebook.com/<?php echo $friend['username']; ?>/picture" ></a>
							</div>
							<div class="m_list_right">
							<span class="m_list_name"><?php echo $friend['name'];?></span>
							<a href="/<?php echo $friend['username'];?>/watchlist" data-options="disable-for-touch:true" data-tooltip class='has-tip tip-top friend-icons' title="<?php echo explode(' ',$friend['name'])[0];?>'s watchlist"><i class="step fi-list-thumbnails size-36" style="font-size:22px;color:#178FE1;" ></i></a>
							<a href="/<?php echo $friend['username'];?>" data-options="disable-for-touch:true" data-tooltip class='has-tip tip-top friend-icons' title="<?php echo explode(' ',$friend['name'])[0];?>'s filmkeep"> <i class="step fi-database size-36" style="font-size:22px;color:#178FE1;" ></i></a>
							</div>
			    			</div>
			    		<?php endif; endforeach;?>
			    		</div>
		    		</div>

		    	</div>
		    	@endif
		    	
	    	</div>
	    </div>
	</div>
   
  
    



	
@stop