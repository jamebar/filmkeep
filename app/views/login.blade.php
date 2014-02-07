@extends('layoutfront')

@section('content')
<div class="row">
    <div class="small-12 large-6 columns">
    <h3>Login</h3>

        {{ Form::open(array('route'=>'login')) }}

        <!-- username field -->
        <p>
            {{ Form::label('email', 'Email' ) }}
            {{ Form::text('email', '' , array('placeholder' => 'email') ) }}
        </p>

        <!-- password field -->
        <p>
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', '' , array('placeholder' => 'password')) }}
        </p>

        <!-- submit button -->
        <p>{{ Form::submit('Login', $attributes = array('class' => 'button')) }}</p>

        {{ Form::close() }}
        <a href="{{ route('join') }}">Need to signup?</a><br>
        <a href="{{ route('facebooklogin') }}">login with facebook</a><br>
        <a href="{{ route('twitterlogin') }}">login with twitter</a>
    </div>
</div>
@stop
