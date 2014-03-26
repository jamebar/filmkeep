@extends('layoutfront')

@section('content')
<link rel="stylesheet" href="/media/css/simplePagination.css">

<script>
page_user_id = <?php echo $page_user['id'];?>;
poster_base = "<?php echo $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][2];?>";
</script>
<style>
body{
    padding-top:0px;
}
.film_cover_bg{
    background:url({{ $latest_review_backdrop_small }}) 0px 0px  no-repeat;
    background-size:cover;
    
}

@media only screen and (min-width: 768px) {
    .film_cover_bg{
        background-image:url({{ $latest_review_backdrop_large }});
    }
}
label{
    margin-bottom:0px;
}

select{
    font-size:12px;
}
</style>
<div class="film_cover_bg">
    <div class="film_cover">
        <div class="row">
            <div class="small-12  columns">
                <div class="fc-title">
                    <div class="fc-profile">
                        <a  href="{{ url($page_user->username) }}"><img class="round-image-tiny"  src="{{ (strlen($page_user['profile_pic']) >1) ? $page_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" ></a>
                    </div>
                    <div class="fc-content">
                         
                        <h2>@if (Auth::check() && Auth::user()->username === $page_user['username']) My @else {{ explode(' ',$page_user['name'])[0]."'s"}} @endif Filmkeep</h2>
                        
                    </div>
                </div> 
            </div> 
                
        </div>
    </div>
</div>
<div class="full-width-section theme-red remove-padding" >
    <div class="row">
        <div class="small-12 medium-6 columns"></div>
        <div class="small-12 medium-6 columns ">
            <div class="row">
                <div class="small-4 medium-4  columns"><span class="stat"><i class="step fi-video"  ></i> <em class="total"></em><br>films</span></div>
                <div class="small-4  medium-4 columns"><a href="/<?php echo $page_user['username'];?>/watchlist"><span class="stat"><i class="step fi-database"  ></i> <em>{{ $watchlist_total }}</em><br>Watchlist</span></a></div>
                <div class="small-4 medium-4  columns"><span class="stat"><i class="step fi-torsos-all"  ></i> <em>{{ count($page_user_following) }}</em><br>following</span></div>
            </div>
        </div>
    </div>
</div>
<div class="full-width-section theme-beige" >

    <div class="row">
        <div class="small-12 medium-4  columns ">
        <div class="row collapse search">
                    <div class="small-2 large-2 columns">
                      <span class="prefix"><i class=" step fi-magnifying-glass " style="font-size:18px;color:#f4e8d0;"></i></span>
                    </div>
                    <div class="small-10 large-10 columns">
                      <input type="text" id="search_myfilmkeep" placeholder="search @if (Auth::check() && Auth::user()->username === $page_user['username']) My @else {{ explode(' ',$page_user['name'])[0] }}'s @endif Filmkeep"/>
                    </div>
                </div>
            
        </div>
        
        <div class="small-12 medium-5 columns hide">
            <select id="sort_dir" class="small-6 medium-6">
                <option value="desc">Sort Descending</option>
                <option value="asc">Sort Ascending</option>
            </select>
            
        </div>
        <div class="small-12 medium-8 columns">
            <div class="my_pagination right"></div>
        </div>

            
            <div class="hide">

                <h5>Filter your films</h5>
                <hr>
                <label><input type="checkbox"> Owned</label>
                <hr>
                <p>When</p>
                <label><input type="checkbox"> Recently</label>
                <label><input type="checkbox"> This Year</label>
                <label><input type="checkbox"> Last year</label>
                <hr>
                <p>Rating Criteria</p>
                <label><input type="checkbox"> Impression before</label>
                <label><input type="checkbox"> Most Liked</label>
                <label><input type="checkbox"> Rewatchability</label>
                <label><input type="checkbox"> Well made</label>
                <label> ...more</label>
                
                <hr>
                <p>Genre</p>
                <label><input type="checkbox"> Horror</label>
                <label><input type="checkbox"> Drama</label>
                <label><input type="checkbox"> Comedy</label>
                <label> ...more</label>
            </div>
        
    </div>
    <div class="row">
        <div class="small-12 medium-12 columns spinner" >
            <span data-bind="with: feedData">
            <ul  class="small-block-grid-3 large-block-grid-6" data-bind="foreach: items">
                                
                    <li>
                        <a class="" data-bind="attr:{href: '{{url('r')}}/' + review_id() + '-' + slug()}" href="">
                                    <img data-bind="attr:{src: poster_base + poster_path()}" src="" />
                                    </a>
                        
                    </li>
                    
                                
                    
            </ul>
        </span>
            
            <div class="row">
                <div class="small-12 medium-12 columns">
                    <div class="my_pagination right"></div>
                </div>
            </div>
        </div>
    </div>          
</div>
@stop

@section('scripts')
    @parent
    <script src="{{ URL::asset('js/vendor/knockout-3.0.0.js') }}"></script>
    <script src="{{ URL::asset('js/vendor/jquery.simplePagination.js') }}"></script>
    <script src="{{ URL::asset('js/myfilmkeep.js') }}"></script>
@stop

@section('styles')
    @parent
    <link rel="stylesheet" href="css/simplePagination.css" >
@stop
