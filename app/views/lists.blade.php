@extends('layoutfront')

@section('content')
<style>

</style>
<div class="film_cover_bg">
        <div class="film_cover" >
            <div class="row">
                <div class="small-12 columns">
                    <div class="fc-title">
                        <div class="fc-profile">
                            <a  href="{{ url($page_user->username) }}"><img class="round-image-tiny"  src="{{ (strlen($page_user['profile_pic']) >1) ? $page_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" ></a>
                        </div>
                        <div class="fc-content">
                            <h2>@if(isset($same_user)) My @else {{ explode(' ',$page_user['name'])[0] }}'s @endif Lists</h2>
                            
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
<div class="full-width-section theme-red" >
    <div class="row">
        <div class="small-12 medium-6 columns">
             
             @if(isset($same_user))
            <a href="" class="button">Create new list</a>
            @endif
        </div>
        
    </div>
</div>
<div class="full-width-section theme-beige" >
    <div class="row">
        <div class="small-12 columns">
            <ul class="lists">
            
            @foreach($lists as $list)

                <li  >
                    <h3>{{ ucwords($list->name) }}</h3>
                    @foreach($list->films as $l_films)
                        <p> {{ $l_films->title }} </p>
                    @endforeach
                </li>
            
            @endforeach
            </ul>
        </div>
    </div>
</div>

@stop