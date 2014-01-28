@extends('layoutfront')

@section('content')

<div class="row">
    <div class="small-12 medium-6 columns">
         <h3><img class="round-image" width="100" height="100" src="{{ $page_user['profile_pic'] }}"> @if(isset($same_user)) My @else {{ explode(' ',$page_user['name'])[0] }}'s @endif Watchlist</h3>
         @if(isset($same_user))
        <p class="hide-for-small" >Re-order your watchlist by dragging the <i class=" step fi-thumbnails size-14" style="font-size:14px;color:#888;"></i> icon</p>
        @endif
    </div>
    @if(isset($same_user))
    
    <div class="small-12 medium-6 columns ">
        <p class="subheader">Add to your watchlist</p>
        <div id="watchlist_search_loader"></div>
        <form id="watchlist_search">
            <div class="row collapse">
                <div class="small-2 large-2 columns">
                  <span class="prefix"><i class=" step fi-plus " style="font-size:18px;color:#888;"></i></span>
                </div>
                <div class="small-10 large-10 columns">
                  <input type="text" class="wlautocomplete" name="query" placeholder="Start typing the film title">
                </div>
            </div>
            
        </form>
        <div id="watchlist_search_message"></div>
    </div>
   
    <?php endif; ?>    
</div>
<div class="row">
    <div class="small-12 columns">
        <ul id="sortable" class="my-watchlist">
        
        @foreach($watchlist as $w)
            <li id="list_{{ $w->w_id }}"  class="list_item">
            <a href="/film/{{  $w->film_id."-".Str::slug($w->title) }}"><img  class="left" src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][1].$w->poster_path }}" /></a>
            <div class="show-for-small watchlist-right">
                <p>{{  $w->title }}</p>
                <a href="javascript:;" data-id="{{  $w->w_id }}" title="remove from watchlist" class="button remove-from-watchlist tiny"><i class="step fi-minus-circle  size-14" style="font-size:14px;color:#fff;"></i> remove</a>
            </div>
            @if(isset($same_user))
            <div class="watchlist_bottom_bar hide-for-small">
            
                <span ><a href="javascript:;" class="button  left tiny handle "  title="drag to re-order"><i class=" step fi-thumbnails size-14" style="font-size:14px;color:#fff;"></i> </a></span>
                <a href="javascript:;" data-id="{{  $w->w_id }}" title="remove from watchlist" class="button remove-from-watchlist tiny"><i class="step fi-minus-circle  size-14" style="font-size:14px;color:#fff;"></i></a>
            </div>
        @endif
            </li>
        
        @endforeach
        </ul>
    </div>
</div>
    

@stop