@extends('layoutfront')

@section('content')
<style>
body{
    background:url({{ DEFAULT_BACKGROUND_PIC }});
    background-size: cover;
}
</style>

@if (Session::has('error'))
  {{ trans(Session::get('reason')) }}
@endif
 <div class="login-box small-12 medium-8 large-6 centered">
    	<div class="row">
	        <div class="small-12 medium-12 columns">
			{{ Form::open(array('route' => array('password.update', $token))) }}
			 
			  <p>{{ Form::label('email', 'Email') }}
			  {{ Form::text('email') }}</p>
			 
			  <p>{{ Form::label('password', 'Password') }}
			  {{ Form::text('password') }}</p>
			 
			  <p>{{ Form::label('password_confirmation', 'Password confirm') }}
			  {{ Form::text('password_confirmation') }}</p>
			 
			  {{ Form::hidden('token', $token) }}
			 
			  <p>{{ Form::submit('Submit') }}</p>
			 
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop