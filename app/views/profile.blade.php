@extends('layoutfront')

@section('content')
<link rel="stylesheet" href="/media/css/simplePagination.css">

<script>
page_user_id = <?php echo $page_user['id'];?>;
poster_base = "<?php echo $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][2];?>";
</script>
<style>
label{
    margin-bottom:0px;
}
.stat{
    width:100px;
    height:100px;
    text-align:center;
    border-radius:50px;
    
    padding-top: 20px;
    display:block;
    color:#888;
    font-weight: 300;
}
.stat em{
    font-size:40px;
    font-style:normal;
    
    margin-top:20px;
}
select{
    font-size:12px;
}
</style>

<div class="row" style="margin-bottom:1em;">
    <div class="small-12 medium-6 columns">
    <h3><img class="round-image"  src="{{ $page_user['profile_pic'] }}" height="100" width="100"> @if (Auth::check() && Auth::user()->username === $page_user['username']) My @else {{ explode(' ',$page_user['name'])[0]."'s"}} @endif Filmkeep</h3>

    </div>
    <div class="medium-6 columns ">
        <div class="row">
            <div class="small-6 medium-3 medium-offset-5 columns"><span class="stat"><i class="step fi-video" style="font-size:40px;color:#888;" ></i> <em class="total"></em><br>films</span></div>
            <div class="small-6  medium-3 columns"><a href="/<?php echo $page_user['username'];?>/watchlist"><span class="stat"><i class="step fi-database" style="font-size:40px;color:#888;" ></i> <em>{{ $watchlist_total }}</em><br>Watchlist</span></a></div>
        </div>
    </div>
</div>


<div class="row">
    <div class="small-12 medium-4  columns ">
    <div class="row collapse">
                <div class="small-2 large-2 columns">
                  <span class="prefix"><i class=" step fi-magnifying-glass " style="font-size:18px;color:#888;"></i></span>
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
            <ul class="small-block-grid-3 large-block-grid-6" data-bind="foreach: items">
                                
                    <li>
                        <a data-bind="attr:{href: '{{url('r')}}/' + review_id() + '-' + slug()}" href="">
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
