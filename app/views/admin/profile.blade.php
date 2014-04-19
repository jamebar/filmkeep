@extends('layoutfront')

@section('content')
<div class="row">
    <div class="small-12 medium-6 columns">
    <h3><img class="round-image"  src="{{ (strlen($logged_in_user['profile_pic']) >1) ? $logged_in_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" height="100" width="100"> My Settings</h3>
    {{ "Filmkeeping for about ". $diff ." ". $unit }}

    @include('admin.custom_criteria')
    
    </div>
</div>
@stop
