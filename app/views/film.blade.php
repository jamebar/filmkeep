@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/comments.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.sticky.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.scrollTo.min.js') }}"></script>
<script>
    $(function(){
       // console.log($(".header-bg").height());
        $(".sub-menu").sticky({topSpacing:$(".header-bg").height() });

        $('.sub-menu a').on('click', function(){
            console.log("hello");
            $.scrollTo( $(this).attr('href'), 800, { offset:{ top:-90 } });
            return false;
        })
    });
    </script>
@stop

@section('content')

@if(isset($film))
<style>
body{
     padding-top:0px;
}
.film_cover_bg{
    background:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][1].$film['backdrop_path'] }}) 0px 0px  no-repeat;
    background-size:cover;
   
}

@media only screen and (min-width: 768px) {
    .film_cover_bg{
        background-image:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][2].$film['backdrop_path'] }});
    }
}
</style>
    <div class="film_cover_bg">
        <div class="film_cover" >
            <div class="row">
                <div class="small-12 columns">
                    <div class="fc-title">
                        
                        <div class="fc-content">
                             @if(Auth::check())
                            
                            <a href="javascript:;" class="add-remove-watchlist @if(array_key_exists($film['id'], $watchlist)) {{"onlist"}} @endif" data-film_id="{{ $film['id'] }}" data-user_id="{{ Auth::user()->id}}"> <i class="step fi-check size-14" style="font-size:14px;color:#d2544c;"></i><i class="step fi-plus size-14" style="font-size:14px;color:#d2544c;"></i> <span></span></a>
                            
                            @endif
                            <h2>{{ $film['title'] }}</h2>
                           
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
        <div class="sub-menu">
            <div class="row">
                <ul class="small-block-grid-4">
                    <li class="sub-menu-1"><a href="#section-overview"><i class="step fi-info"></i> <span>Overview</span></a></li>
                    <li class="sub-menu-2"><a href="#section-ratings"><i class="step fi-star"></i> <span>Ratings</span></a></li>
                    <li class="sub-menu-3"><a href="#section-notes"><i class="step fi-page-edit"></i> <span>Notes</span></a></li>
                    <li class="sub-menu-4"><a href="#section-comments"><i class="step fi-comment"></i> <span>Comments</span></a></li>
                </ul>
            </div>
        </div>

        <!--
        <div class="row">

            <div class="small-12 columns ">
                <div class="film_actions_bar">
                    
                   
                         <a href="javascript:;" id="{{ $film['tmdb_id'] }}" data-id="{{ $film['id'] }}" class="load-trailer "><i class="step fi-video size-30" style="font-size:30px;color:#aaa;" ></i></a>
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
                    
                    <a href="javascript:;" class="button tiny right add-remove-watchlist @if(array_key_exists($film['film_id'], $watchlist)) {{"onlist"}} @endif" data-film_id="{{ $film['film_id'] }}" data-user_id="{{ Auth::user()->id}}"> <i class="step fi-check size-14" style="font-size:14px;color:#fff;"></i><i class="step fi-plus size-14" style="font-size:14px;color:#fff;"></i> <span></span></a>
                    
                    @endif
                </div>  
                <div class="row" id="{{ $film['id']}}_con">
                   <div id="" class="trailer-con small-12 columns"> </div>
                </div>
            </div>
            
        </div>-->
       
        <div class="full-width-section theme-beige" id="section-overview">
            <div class="row">
                
                <div class="small-12 medium-3  columns">
                 
                 <a class="radius trailer-thumb trailer" id="{{ $film['tmdb_id'] }}" data-id="{{ $film['id'] }}" href="javascript:;" style="backround:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][0].$film['backdrop_path'] }}) no-repeat; background-size:cover;">
                    <img class="radius" src="{{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][0].$film['backdrop_path'] }}"/>
                    <span></span>
                 </a>
                   
                    
                </div>
                <div class="small-12 medium-6  columns">
                    @if(isset($tmdb_info['release_date']) )
                        <p><span>Released </span>
                        {{ date("M d, Y", strtotime($tmdb_info['release_date'] ))  }}</p>
                    @endif
                    <p> {{ Str::limit($tmdb_info['overview'], 200) }} </p>
                     <!-- show streaming options -->
                    @if(isset($streaming['relevant_results']))
                        @foreach ($streaming['relevant_results'] as $results)
                            <p>Stream:</p>
                            @foreach($results['streaming'] as $s_results)
                                
                                @if( count($s_results['titles']) > 0)
                                {{ link_to($s_results['titles'][0]['url'], $s_results['name'], $attributes = array('target'=>'_blank', 'class'=> $s_results['slug']), $secure = null); }} |
                                
                                @endif

                            @endforeach

                        @endforeach

                        <!-- <br><a href="" class="small">streaming info provided by synopsi.tv</a> -->
                   @else

                   @endif
                </div>
                <div class="small-12 medium-3 columns f_stats">
                     @if($rotten && isset($rotten->ratings->critics_rating))
                        <span class="rotten-score"><i class="{{ Str::slug($rotten->ratings->critics_rating) }}"></i> {{ $rotten->ratings->critics_score }}%</span>
                    @endif
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
                    
                    
                </div>
            </div>
        </div><!-- end feed padding -->

        
        <div class="full-width-section theme-orange notes" id="section-notes">
            <div class="row">
                <div class="small-12 columns">
                    
                </div>
            </div>
        </div>
        
        <div class="full-width-section theme-toast" id="section-comments">
            <div class="row comment-section">
                <div class="small-12  columns"><h4 class="subheader">Comments</h4></div>
                <div class="small-12  columns comment-box" id="reviews-{{ $film['id']}}"><span class="filler"><p>@if(Auth::check()) Be the first to comment @else You must be logged in to comment  @endif</p></span></div>
                @if(Auth::check())
                <div class="small-12  columns">
                    <form class="comment_form" data-id="{{ $film['id']}}" data-type="reviews">
                        <textarea name="comment"  placeholder="Add a comment"></textarea>
                        <div class="spoiler-check">
                            <label><span class="show-for-medium-up">contains spoilers</span><span class="show-for-small">spoilers</span></label>
                            <input type="checkbox" name="spoiler" >
                        </div>
                        <input type="submit" id="submit_comment" class="right button radius" value="Comment"/>
                    </form>
                </div>
                @endif
            </div>
        </div>
    
@endif
@stop