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
        
        <p><a class="button fb-btn medium-8 small-12" href="{{ route('facebooklogin') }}"><i class="fi-social-facebook"></i> Login with facebook</a></p>
             <p><a class="button tw-btn medium-8 small-12" href="{{ route('twitterlogin') }}"><i class="fi-social-twitter"></i> Login with twitter</a></p>
             <p><a class="button google-btn medium-8 small-12" href="{{ route('googlelogin') }}"><i class="fi-social-google-plus"></i> Login with google</a></p>
             <span class="login-or">or</span>
             
                {{ Form::open(array('route'=>'login')) }}

                <!-- username field -->
                <p>
                    {{ Form::label('email', 'Email' ) }}
                    {{ Form::text('email', '' , array('placeholder' => 'email' ) ) }}
                </p>

                <!-- password field -->
                <p>
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password', '' , array('placeholder' => 'password')) }}
                </p>

                <!-- submit button -->
                <p>{{ Form::submit('Login', $attributes = array('class' => 'button')) }}</p>

                {{ Form::close() }}
            <p> <a href="{{ route('password.remind') }}" class="">Forgot your password?</a></p>
            <p>Don't have an account yet? <a href="{{ route('join') }}" class="">Signup</a></p>
           
        </div>
    </div>
</div>
@stop
