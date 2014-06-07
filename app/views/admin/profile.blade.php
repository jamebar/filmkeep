@extends('layoutfront')

@section('scripts')
@parent

@stop

@section('content')
<style>
body{
    background:url({{ DEFAULT_BACKGROUND_PIC }});
    background-size: cover;
}
</style>

<div class="small-12 medium-10 large-8 centered white-box profile-settings">
        

    <h3><img class="round-image"  src="{{ (strlen($logged_in_user['profile_pic']) >1) ? $logged_in_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" height="100" width="100"> My Settings</h3>
    {{ "Filmkeeping for about ". $diff ." ". $unit }}
    <p></p>
    <dl class="tabs" data-tab data-options="deep_linking:true;scroll_to_content: false">
        <dd class="active"><a href="#panel2-1"><i class="step fi-info"></i> <span class="show-for-medium-up">My Info</span></a></dd>
        <dd><a href="#panel2-2"><i class="step fi-graph-horizontal"></i> <span class="show-for-medium-up">Custom Criteria</span></a></dd>
        <dd><a href="#panel2-3"><i class="step fi-share"></i> <span class="show-for-medium-up">Social Networks</span></a></dd>
        <dd><a href="#panel2-4"><i class="step fi-share"></i> <span class="show-for-medium-up">Invites</span></a></dd>
    </dl>
         
    
     <div class="tabs-content">
      
        <div class="row content active" id="panel2-1">
        	<div class="small-12  columns">
        		{{ Form::model($user, array('route' => array('userUpdate', 'id='.$user->id))) }}
        		{{ Form::label('email', 'E-Mail Address') }}
        		{{ Form::text('email') }}
        		{{ Form::label('username', 'Username') }}
        		{{ Form::text('username') }}
        		{{Form::submit('Save', array('class'=> 'button')) }}
        		{{ Form::close() }}
        	</div>
        </div>

        <div class="row content" id="panel2-2">
            <div  id="section-criteria">
                @include('admin.custom_criteria')
            </div>   
        </div>

        <div class="row content" id="panel2-3">
            <div class="small-12 columns">
                <p>To experience the full affect of Filmkeep, connect your social networks here</p>

                <p><a class="button fb-btn medium-6 large-6 small-12" href="{{ route('facebooklogin') }}"><i class="fi-social-facebook"></i> Connect with facebook</a></p>
                 <p><a class="button google-btn medium-6 large-6 small-12" href="{{ route('googlelogin') }}"><i class="fi-social-google-plus"></i> Connect with google</a></p>

            </div>
        </div>

        <div class="row content" id="panel2-4">
            
            @include('admin.invites')
           
        </div>

    </div>
     
</div>

@stop
