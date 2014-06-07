@section('scripts')
@parent
	<script src="{{ URL::asset('js/invites.js') }}"></script>
	
@stop

<div class="row">
	
	<div id="invites" class="small-12 columns">
	<p>Create Invites</p>
		<ul class="invites c-list">
		@foreach( $invites as $invite )

		<li class="c-item">
			<span>{{ $invite->email }}</span>
			<div class="right custom_type_controls">
				
				<a href="javascript:;" data-dropdown="drop{{ $invite->id }}" class="dropdown" ><i class="step fi-x size-36" style="font-size:22px;color:#178FE1;" ></i></a>
				<ul id="drop{{ $invite->id }}" data-dropdown-content class="f-dropdown">
					<li><a class="delete-invite" data-id="{{ $invite->id }}" href="javascript:;">Yes, delete <i class="step fi-trash " style="font-size:18px;color:#d50606;margin-left:1em" ></i></a></li>
					<li><a href="javascript:;">no, nevermind</a></li>
				</ul>
			</div>
		</li>

		@endforeach


		</ul>

		<form class="invite-form">
			<div class="row">
				<div class="small-10 columns">
					<input type="hidden" name="referrer_user_id" value="{{ $logged_in_user->id }}" >
					<input type="text" name="email" placeholder="Invite a friend" >
				</div>
				<div class="small-2 columns">
					<a href="javascript:;" class="add-invite right" ><i class="step fi-plus size-36" style="font-size:34px;color:#178FE1;" ></i></a>
				</div>
			
			</div>
		</form>
	</div>
</div>