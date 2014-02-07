@extends('layoutfront')

@section('content')
<div class="row">
    <div class="small-12 large-6 columns">
    <h3>Profile</h3>

    {{ Auth::user()->name }}

    @include('admin.custom_criteria')
    </div>
</div>
@stop
