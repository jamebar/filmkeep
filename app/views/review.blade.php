@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/comments.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.sticky.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.scrollTo.min.js') }}"></script>
<script>
    $(function(){
        $(".sub-menu").sticky({topSpacing:50});

        $('.sub-menu a').on('click', function(){
            console.log("hello");
            $.scrollTo( $(this).attr('href'), 800, { offset:{ top:-90 } });
            return false;
        })
    });
    </script>
@stop

@section('content')

@if(isset($review))
<style>
body{
    background:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][1].$review['backdrop_path'] }}) 0px 0px  no-repeat;
    background-size:100%;
}

@media only screen and (min-width: 768px) {
    body{
        background-image:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][2].$review['backdrop_path'] }});
    }
}
</style>

	    <div class="film_cover" style="padding:13%;min-height:225px;">
            <div class="fc-title">
                <div class="fc-profile">
                    <a  href="{{ url($page_user->username) }}"><img class="round-image-tiny"  src="{{ (strlen($page_user['profile_pic']) >1) ? $page_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" height="100" width="100"></a>
                </div>
                <div class="fc-content">
                     @if(Auth::check())
                    
                    <a href="javascript:;" class="add-remove-watchlist @if(array_key_exists($review['film_id'], $watchlist)) {{"onlist"}} @endif" data-film_id="{{ $review['film_id'] }}" data-user_id="{{ Auth::user()->id}}"> <i class="step fi-check size-14" style="font-size:14px;color:#d2544c;"></i><i class="step fi-plus size-14" style="font-size:14px;color:#d2544c;"></i> <span></span></a>
                    
                    @endif
                    <h2>{{ $review['title'] }}</h2>
                    @if(Auth::check() && $page_user['username'] === Auth::user()->username)
                            <a style="margin-bottom:0em;" class="edit-review"  data-id="{{ $review['id'] }}" href="javascript:;"><i class="step fi-pencil size-14" style="font-size:14px;color:#ccc;"></i> Edit</a>
                    @endif  
                </div>
            </div> 
           
	    </div>

        <div class="sub-menu">
            <div class="row">
                <ul class="small-block-grid-4">
                    <li class="sub-menu-1"><a href="#section-overview"><i class="step fi-info"></i> <span>Overview</span></a></li>
                    <li class="sub-menu-2"><a href="#section-ratings"><i class="step fi-star"></i> <span>My Ratings</span></a></li>
                    <li class="sub-menu-3"><a href="#section-notes"><i class="step fi-page-edit"></i> <span>My Notes</span></a></li>
                    <li class="sub-menu-4"><a href="#section-comments"><i class="step fi-comment"></i> <span>Comments</span></a></li>
                </ul>
            </div>
        </div>

        <!--
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
            
        </div>-->
       
        <div class="full-width-section theme-beige" id="section-overview">
            <div class="row">
                
                <div class="small-12 medium-2  columns">
                 @if(isset($tmdb_info['release_date']) )
                        <p><span>Released </span>
                        {{ date("M d, Y", strtotime($tmdb_info['release_date'] ))  }}</p>
                    @endif
                    @if($rotten && isset($rotten->ratings->critics_rating))
                        <span class="rotten-score"><i class="{{ Str::slug($rotten->ratings->critics_rating) }}"></i> {{ $rotten->ratings->critics_score }}%</span>
                    @endif
                    
                </div>
                <div class="small-12 medium-6  columns">
                    <p> {{ Str::limit($tmdb_info['overview'], 200) }} </p>
                </div>
                <div class="small-12 medium-4 columns f_stats">
                    @if(isset($tmdb_info['budget']) && $tmdb_info['budget'] > 0)
                        <p><span>Budget</span>
                        {{ number_format( $tmdb_info['budget'] )  }}</p>
                    @endif
                    @if(isset($tmdb_info['revenue']) && $tmdb_info['revenue'] > 0)
                        <p><span>Revenue</span>
                        {{ number_format( $tmdb_info['revenue'] ) }}</p>
                    @endif
                    
                </div>
                
                             
                   
            </div>
        </div>
        <div class="full-width-section theme-red" id="section-ratings">
        	<div class="row">
                
                <div class="small-12  columns">
                	@foreach($review['ratings'] as $r) 
                			@if( $r->label != null  && $r->rating != null)
                		
                		
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

                            <div class="rating-line">
                                <span class="rating-line-dot current-dot" style="left:{{ floor($r->rating) }}%;"></span>
                                @foreach( $all_reviews as $item )
                                    @foreach( $item['ratings'] as $all )
                                        @if($all['rating_type'] == $r->type_id)
                                        <span class="rating-line-dot" style="left:{{ floor($all['rating']) }}%"></span>
                                        
                                        @endif
                                    @endforeach
                                @endforeach
                                <span class="base-line"></span>
                                <span class="active-line" style="width:{{ floor($r->rating)  }}%"></span>
                            </div>
                	         <!--<div class="progress info radius"><span class="meter" style="width: {{ $r->rating }}%"></span></div>-->
                	   </div>
                	
        						@endif
                		@endforeach
                	
                </div>
            </div>
        </div><!-- end feed padding -->

        @if(isset($review['comments']) && strlen($review['comments'])>1) 
        <div class="full-width-section theme-orange notes" id="section-notes">
            <div class="row">
                <div class="small-12 columns">
                    
                        <p><span><em class="quote-open">&ldquo;</em></span>{{ nl2br($review['comments'])}}<span><em class="quote-close">&rdquo;</em></span></p>
                     
                </div>
            </div>
        </div>
        @endif 
        <div class="full-width-section theme-toast" id="section-comments">
            <div class="row comment-section">
                <div class="small-12  columns"><h4 class="subheader">Comments</h4></div>
                <div class="small-12  columns comment-box" id="reviews-{{ $review['id']}}"></div>
                @if(Auth::check())
                <div class="small-12  columns">
                    <form class="comment_form" data-id="{{ $review['id']}}" data-type="reviews">
                        <textarea name="comment"  placeholder="Add a comment"></textarea>
                        <div class="spoiler-check">
                            <label><span class="show-for-medium-up">contains spoilers</span><span class="show-for-small">spoilers</span></label>
                            <input type="checkbox" name="spoiler" >
                        </div>
                        <input type="submit" id="submit_comment" class="right button" value="Comment"/>
                    </form>
                </div>
                @endif
            </div>
        </div>
    
@endif
@stop