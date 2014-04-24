@extends('layoutfront')
@section('scripts')
@parent
<script src="{{ URL::asset('js/vendor/jquery.sticky.js') }}"></script>
<script src="{{ URL::asset('js/vendor/jquery.scrollTo.min.js') }}"></script>
<script>
    $(function(){
       // console.log($(".header-bg").height());
        $(".sub-menu").sticky({topSpacing:$(".header-bg").height() });

        $('.sub-menu a').on('click', function(){
           
            $.scrollTo( $(this).attr('href'), 800, { offset:{ top:-90 } });
            return false;
        })
    });
    </script>
@stop

@section('content')
<div class="row">
    	<div class="small-12 medium-6 columns">
	    <h3><img class="round-image"  src="{{ (strlen($logged_in_user['profile_pic']) >1) ? $logged_in_user['profile_pic'] : url(DEFAULT_PROFILE_PIC) }}" height="100" width="100"> My Settings</h3>
	    {{ "Filmkeeping for about ". $diff ." ". $unit }}
 	</div>
</div>
<div class="sub-menu">
    <div class="row">
        <ul class="small-block-grid-4">
            <li class="sub-menu-1"><a href="#section-overview"><i class="step fi-info"></i> <span>Profile</span></a></li>
            <li class="sub-menu-2"><a href="#section-criteria"><i class="step fi-star"></i> <span>Custom Criteria</span></a></li>
            <li class="sub-menu-3"><a href="#section-notes"><i class="step fi-page-edit"></i> <span>Social Connect</span></a></li>
            <li class="sub-menu-4"><a href="#section-comments"><i class="step fi-comment"></i> <span>Network</span></a></li>
        </ul>
    </div>
</div>
<div class="full-width-section theme-beige" id="section-overview">
	<div class="row">
		<div class="small-12 medium-6">
			{{ Form::model($user, array('route' => array('user.update', $user->id))) }}
			{{ Form::label('email', 'E-Mail Address') }}
			{{ Form::text('email') }}
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username') }}
			{{Form::submit('Save', array('class'=> 'button')) }}
			{{ Form::close() }}
		</div>
	</div>
</div>

<div class="full-width-section theme-red" id="section-criteria">
    @include('admin.custom_criteria')
</div>   
   
@stop
