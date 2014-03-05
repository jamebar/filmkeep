@extends('layoutfront')

@section('scripts')
@parent
<script src="{{ URL::asset('js/comments.js') }}"></script>
@stop

@section('content')

@if(isset($film))
<style>
body{
    background:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][1].$film['backdrop_path'] }}) 0px 40px  no-repeat;
    background-size:contain;
}

@media only screen and (min-width: 768px) {
    body{
        background-image:url({{$image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][2].$film['backdrop_path'] }});
    }
}
</style>
<div class="row">
    <div class='small-12 medium-12 columns'>
        <div class="film_cover" style="padding:15%">
        
           
           @if(strlen($film['backdrop_path']) > 1)

          
            @else
            <img class="" src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][2].$film['poster_path'] }}" />
            @endif
        </div>
        <div class="row">

            <div class="small-12 columns ">
                <div class="film_actions_bar">
                    
                   
                         <a href="javascript:;" id="{{ $film['tmdb_id'] }}" data-id="{{ $film['id'] }}" class="load-trailer "><i class="step fi-video size-30" style="font-size:30px;color:#aaa;" ></i></a>
                        
                    
                     @if(Auth::check())
                    
                    <a href="javascript:;" class="button tiny right add-remove-watchlist @if(array_key_exists($film['id'], $watchlist)) {{"onlist"}} @endif" data-film_id="{{ $film['id'] }}" data-user_id="{{ Auth::user()->id}}"> <i class="step fi-check size-14" style="font-size:14px;color:#fff;"></i><i class="step fi-plus size-14" style="font-size:14px;color:#fff;"></i> <span></span></a>
                    
                    @endif
                </div>  
                <div class="row" id="{{ $film['id']}}_con">
                   <div id="" class="trailer-con small-12 columns"> </div>
                </div>
            </div>
            
        </div>
       <div class="feed-padding">
            <div class="row" >
            
                <div class="small-12 columns">
                    
                    <h2>{{ $film['title'] }}</h2>
                        
                </div>
                <div class="small-5 columns">
                   
                </div>
            </div>
            <hr style="margin:0em;">
        </div>
        <div class="feed-padding">
            <div class="row">
                <div class="small-12 medium-4 large-4 columns">
                    
                    <div class="medium-12 columns ">
                            
                            @if($rotten && isset($rotten->ratings->critics_rating))
                                <span class="rotten-score"><i class="{{ Str::slug($rotten->ratings->critics_rating) }}"></i> {{ $rotten->ratings->critics_score }}%</span>
                            @endif
                        
                            <p></p>
                            <p> {{ $tmdb_info['overview'] }} </p>

                            @if(isset($tmdb_info['budget']) && $tmdb_info['budget'] > 0)
                                <h3>Budget</h3>
                                {{ number_format( $tmdb_info['budget'] )  }}
                            @endif

                            @if(isset($tmdb_info['revenue']) && $tmdb_info['revenue'] > 0)
                                <h3>Revenue</h3>
                                {{ number_format( $tmdb_info['revenue'] ) }}
                            @endif

                            @if(isset($tmdb_info['release_date']) )
                                <h3>Release Date</h3>
                                {{ date("M d, Y", strtotime($tmdb_info['release_date'] ))  }}
                            @endif
                        
                        
                    </div>
                </div>
                <div class="small-12 medium-8 large-8 columns">
                    
                    
                </div>
            </div>
        </div><!-- end feed padding -->
        
    </div>
        
</div>
@endif
@stop