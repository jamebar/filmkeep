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
<div class="login-box small-12 medium-6 large-4 centered">
    <div class="row">
        <div class="small-12 medium-12 columns">
            <div id="join-social">
                <h3>Join with social</h3>
                <p class="subheader">To get the most out of Filmkeep, use your Facebook or Google account to signup.</p>
                <hr>
                 <p><a class="button fb-btn  small-12" href="{{ route('facebooklogin') }}"><i class="fi-social-facebook"></i> Join with facebook</a>
                 <a class="button google-btn  small-12" href="{{ route('googlelogin') }}"><i class="fi-social-google-plus"></i> Join with google</a></p>
                 
            </div>
           <hr>
            <div id="join-email">
                <h3>Join with email</h3>

                @foreach ($errors->all() as $message)
                
                <p>{{ $message }}</p>
                @endforeach

                {{ Form::open(array('route'=>'join')) }}

                <!-- fullname field -->
                <p>
                    
                    {{ Form::text('fullname', '' , array('placeholder' => 'First and last name') ) }}
                </p>

                <!-- email field -->
                <p>
                    
                    {{ Form::text('email', '' , array('placeholder' => 'Email') ) }}
                </p>

                <!-- password field -->
                <p>
                    
                    {{ Form::password('password',  array('placeholder' => 'password')) }}
                </p>

                <!-- submit button -->
                <p>{{ Form::submit('Create Account', $attributes = array('class' => 'button small-12')) }}</p>

                {{ Form::close() }}

                <p>By creating an account, I accept Filmkeep's Terms of Service and Privacy Policy.</p>
                <p>Already a member? <a href="{{ route('login') }}">Sign in here</a></p>
              </div> 
        </div>
    </div>
</div>

@stop
