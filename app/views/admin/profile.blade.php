@extends('layoutfront')

@section('content')
<div class="row">
    <div class="small-12 large-6 columns">
    <h3>Profile</h3>

    <!-- check for login error flash var -->
    @if (Session::has('flash_error'))
        <div id="flash_error" class="alert-box warning">{{ Session::get('flash_error') }}</div>
    @endif

    @if (Session::has('flash_notice'))
        <div id="flash_notice" class="alert-box ">{{ Session::get('flash_notice') }}</div>
    @endif


    {{ Auth::user()->name }}
    </div>
</div>
@stop
