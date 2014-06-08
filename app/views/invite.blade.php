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
        <h3>Welcome to Filmkeep {{ $name }}</h3>
        <p>To complete your registration, please enter your invite code below</p>
        <hr>
        
        
         
            {{ Form::open(array('route'=>'login')) }}

            <!-- username field -->
            <p>
                
                {{ Form::text('invite', '' , array('placeholder' => 'Enter your invite code' ) ) }}
            </p>

            <!-- submit button -->
            <p>{{ Form::submit('Finish', $attributes = array('class' => 'button small-12')) }}</p>

            {{ Form::close() }}
           
           
        </div>
    </div>
</div>
@include('faqbottom')
@stop
