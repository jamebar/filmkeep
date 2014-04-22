@extends('layoutfront')

@section('content')
<style>
body{
    background:url(/img/bg/bg-jimmy-stewart-1600.jpg);
    background-size: cover;
}
</style>
<div class="login-box small-12 medium-8 large-6 centered">
    <div class="row">
        <div class="small-12 medium-12 columns">
            <div id="join-social">
                <h3>Join with social</h3>
                <p class="subheader">To get the most out of Filmkeep, use your Facebook or Google account to signup.</p>
                 <p><a class="button fb-btn medium-8 large-6 small-12" href="{{ route('facebooklogin') }}"><i class="fi-social-facebook"></i> Join with facebook</a></p>
                 <p><a class="button google-btn medium-8 large-6 small-12" href="{{ route('googlelogin') }}"><i class="fi-social-google-plus"></i> Join with google</a></p>
                 
            </div>
            <span class="login-or">or</span>
            <div id="join-email">
                <h3>Join with email</h3>

                @foreach ($errors->all() as $message)
                
                <p>{{ $message }}</p>
                @endforeach

                {{ Form::open(array('route'=>'join')) }}

                <!-- fullname field -->
                <p>
                    {{ Form::label('fullname', 'First and last name' ) }}
                    {{ Form::text('fullname', '' , array('placeholder' => 'First and last name') ) }}
                </p>

                <!-- email field -->
                <p>
                    {{ Form::label('email', 'Email' ) }}
                    {{ Form::text('email', '' , array('placeholder' => 'Email') ) }}
                </p>

                <!-- password field -->
                <p>
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password', '' , array('placeholder' => 'password')) }}
                </p>

                <!-- submit button -->
                <p>{{ Form::submit('Join', $attributes = array('class' => 'button small-6')) }}</p>

                {{ Form::close() }}

                <p>By creating an account, I accept Filmkeep's Terms of Service and Privacy Policy.</p>
                <p>Already a member? <a href="{{ route('login') }}">Sign in here</a></p>
              </div> 
        </div>
    </div>
</div>
<script>
$(function(){

});
</script>
@stop
