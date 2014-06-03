@extends('layoutfront')

@section('content')
<style>
html{
    background:url({{ DEFAULT_BACKGROUND_PIC }}) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
body{
    background:none;
}
</style>
<div class="login-box small-12 medium-6 large-4 xlarge-3 centered">
    <div class="row">
        <div class="small-12 medium-12 columns">
        <h3>Member Sign-in</h3>
        <hr>
        <p><a class="button fb-btn medium-12 small-12" href="{{ route('facebooklogin') }}"><i class="fi-social-facebook"></i> Login with facebook</a>

         <a class="button google-btn medium-12 small-12" href="{{ route('googlelogin') }}"><i class="fi-social-google-plus"></i> Login with google</a></p>
         <hr>
         
            {{ Form::open(array('route'=>'login')) }}

            <!-- username field -->
            <p>
                
                {{ Form::text('email', '' , array('placeholder' => 'email' ) ) }}
            </p>

            <!-- password field -->
            <p>
                
                {{ Form::password('password',  array('placeholder' => 'password') ) }}
            </p>

            <!-- submit button -->
            <p>{{ Form::submit('Login', $attributes = array('class' => 'button small-12')) }}</p>

            {{ Form::close() }}
            <p> <a href="{{ route('password.remind') }}" class="">Forgot your password?</a></p>
            <p>Don't have an account yet? <a href="{{ route('join') }}" class="">Signup</a></p>
           
        </div>
    </div>
</div>
@include('faqbottom')
@stop
