@extends('layoutfront')

@section('content')
		@if (Session::has('flash_notice'))
			<div id="flash_notice" data-alert data-options="animation_speed:500;" class="alert-box ">{{ Session::get('flash_notice') }} <a href="#" class="close">&times;</a></div>
		@endif
		<p>{{ $films->title }} </p>
	
@stop