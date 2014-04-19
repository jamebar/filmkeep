@extends('layoutfront')

@section('content')
<style>
body{
    background:url({{ DEFAULT_BACKGROUND_PIC }});
    background-size: cover;
}
</style>
 <div class="login-box small-12 medium-8 large-6 centered">
    	<div class="row">
	        <div class="small-12 medium-12 columns">
		@if (Session::has('error'))
		  {{ trans(Session::get('reason')) }}
		@elseif (Session::has('success'))
		  An email with the password reset has been sent.
		@endif
		<h3>Forgot your password?</h3>
		 <p>No worries — we’ve got you covered. Give us the email address you use to log in to Filmkeep and we’ll send you instructions for resetting your password.</p>
		{{ Form::open(array('route' => 'password.request')) }}
		 
		
		  {{ Form::text('email','' , $attributes = array('placeholder' => 'Email')) }}</p>
		 
		  <p>{{ Form::submit('Submit', $attributes = array('class' => 'button')) }}</p>
		 
		{{ Form::close() }}
		</div>
	</div>
</div>
@stop
		
