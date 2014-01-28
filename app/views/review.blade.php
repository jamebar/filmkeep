@extends('layoutfront')

@section('content')

@if(isset($review))

<div class="row">
	<div class='small-12 medium-8 columns'>
	    <div class="film_cover">
	       <h2 class=""><a  href="{{ url(Auth::user()->username) }}">{{ Auth::user()->name }}</a> / {{ $review['title'] }}</h2>
	       
           @if(strlen($review['backdrop_path']) > 1)
		  <img class="" src="{{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][1].$review['backdrop_path'] }}" />
            @else
            <img class="" src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][2].$review['poster_path'] }}" />
            @endif
	    </div>
        <div class="row">
            <div class="small-12 columns ">
                <div class="film_actions_bar">
                    
                   
                         <a href="javascript:;" id="{{ $review['tmdb_id'] }}" data-id="{{ $review['id'] }}" class="load-trailer "><i class="step fi-video size-30" style="font-size:30px;color:#aaa;" ></i></a>
                        @if(isset($num_friends_rated) && $num_friends_rated >0)
                        
                        <a href="javascript:;" data-dropdown='compare_friends_list' class="notif_parent"  style="margin-left:2em;" id="compare" ><i  class="fi-results-demographics size-30" style="font-size:30px;color:#aaa;" ></i> @if(isset($num_friends_rated) && $num_friends_rated >0) <span  class='notif'>{{ $num_friends_rated }}</span> @endif</a>
                        
                        <div id="compare_friends_list" class="f-dropdown content small" data-dropdown-content>
                        	<p>Compare ratings from:</p>
                            @if(isset($user_film['id']) && Auth::check() && $page_user['username'] !== Auth::user()->username)
                                 <a href="" class="compare" id="{{ $user_film['id'] }}"><img src="{{ Auth::user()->profile_pic }}" ></a><div class="small-10" id="loader-{{ $user_film['id'] }}"><div id="loader"></div></div>
                            @endif
                            
                            @foreach($friends as $friend)
                                @if(!empty($friend['rated_film']))
                                    <a href="" class="compare" id="{{ $friend['rated_film'] }}"><img src="{{ $friend['profile_pic'] }}" ></a><div class="small-10" id="loader-{{ $friend['rated_film'] }}"></div>
                                @endif
                            @endforeach
                        </div>
                        
                    
                        @endif
                    
                     @if(Auth::check())
					
              		<a href="javascript:;" class="button tiny right add-remove-watchlist @if(array_key_exists($review['film_id'], $watchlist)) {{"onlist"}} @endif" data-film_id="{{ $review['film_id'] }}" data-user_id="{{ Auth::user()->id}}"> <i class="step fi-check size-14" style="font-size:14px;color:#fff;"></i><i class="step fi-plus size-14" style="font-size:14px;color:#fff;"></i> <span></span></a>
              		
                    @endif
                </div>  
                <div class="row" id="{{ $review['id']}}_con">
                   <div id="" class="trailer-con small-12 columns"> </div>
                </div>
            </div>
            
        </div>
       <div class="feed-padding">
       		<div class="row" >
			
		        <div class="small-7 columns">
		        	
		        	<h4 class="subheader">Review</h4>
		        		
		        </div>
		        <div class="small-5 columns">
		        	@if(Auth::check() && $page_user['username'] === Auth::user()->username)
				    		<a style="line-height: 2em;" class="right edit-review"  data-id="{{ $review['id'];?>" href="javascript:;"><i class="step fi-pencil size-14" style="font-size:14px;color:#ccc;"></i> Edit</a>
				    @endif	
		        </div>
    		</div>
    		<hr style="margin:0em;">
    	</div>
        <div class="feed-padding">
        	
        	@foreach($review['ratings'] as $r) 
        			@if( $r->label != null )
        		
        		
        	   <div class="ratings" data-typeid="{{ $r->type_id }}">
        		 <label class="sliders show-for-medium-up"><?php 
                        
                        if(strpos($r->label, '|') >-1){
                            $l = explode("|",$r->label);
                            echo $l[0]."<span class='label-right'>".$l[1]."</span>";
                        }else {
                            echo $r->label;  
                        }?></label>
                        <label class="sliders show-for-small"><?php 
                        
                        if(strpos($r->label_short, '|') >-1){
                            $l = explode("|",$r->label_short);
                            echo $l[0]."<span class='label-right'>".$l[1]."</span>";
                        }else {
                            echo $r->label_short; 
                        }?></label>
        	         <div class="progress  info radius"><span class="meter" style="width: {{ $r->rating }}%"></span></div>
        	   </div>
        	
						@endif
        		@endforeach
        	@if(isset($review['comments']) && strlen($review['comments'])>1) 
        	     <hr><label>Notes:</label>
        	   
        	    <p>{{ nl2br($review['comments'])}}</p>
        	@endif	
        </div><!-- end feed padding -->
        <div class="feed-padding">
            <div class="row comment-section">
                <div class="small-12 columns"><h4 class="subheader">Comments</h4></div>
                <div class="small-12 columns comment-box" id="reviews-{{ $review['id']}}"></div>
                @if(Auth::check())
                <div class="small-12 columns">
                    <form class="comment_form" data-id="{{ $review['id']}}" data-type="reviews">
                        <textarea name="comment"  placeholder="Add a comment"></textarea>
                        <input type="submit" id="submit_comment" class="right button" value="Comment"/>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="medium-4 columns  show-for-medium-up">
	    	<div >
		    	<div class="rm ">
                
		    	</div>
                
		    	<div class="rm">
		    		<h5>Friends also rated this</h5>
		    		
		    	</div>
                <div class="rm">
                    <h5>Recommend this to a friend</h5>
                    
                </div>
		    	
		    	
	    	</div>
	    </div>
</div>
@endif
@stop