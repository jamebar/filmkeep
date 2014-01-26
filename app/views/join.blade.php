@extends('layoutfront')

@section('content')
<div class="row">
    <div class="small-12 large-6 columns">
    <h3>Join</h3>

    <!-- check for login error flash var -->
    @if (Session::has('flash_error'))
        <div id="flash_error" class="alert-box warning">{{ Session::get('flash_error') }}</div>
    @endif

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
        <p>{{ Form::submit('Join', $attributes = array('class' => 'button')) }}</p>

        {{ Form::close() }}
        <a href="{{ route('login') }}">Already have an account?</a><br>
        <a href="{{ route('facebooklogin') }}">Join with facebook</a><br>
        <a href="{{ route('twitterlogin') }}">Join with twitter</a>
    </div>
</div>
@stop
