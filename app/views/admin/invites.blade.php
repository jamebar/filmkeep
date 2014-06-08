@section('scripts')
@parent
	<script src="{{ URL::asset('js/invites.js') }}"></script>

@stop

<div class="row">
	
	<div id="invites" class="small-12 columns">
	<div class="row">
		<div class="small-4 columns">
			<span class="stat"><i class="step fi-page-multiple"></i> <em>10</em><br>Invites Allowed</span>
		</div>
		<div class="small-4 columns">
			<span class="stat"><i class="step fi-mail"></i> <em>{{ $invites->count() }}</em><br>Invites Sent</span>
		</div>
		<div class="small-4 columns">
			<span class="stat"><i class="step fi-star"></i> <em>{{ $invites_redeemed }}</em><br>Invites Redeemed</span>
		</div>
		
	</div>
	<form class="invite-form">
		<div class="row">
			<div class="small-12 columns">
				<h2>Invite friends to join</h2>
				<p>One of the things that makes Filmkeep special is the ability to share and compare reviews with friends.  During the initial launch of Filmkeep, we'll be invite only and you have been granted 10 invites to use.  </p>
			</div>
			<div class="small-12 columns">
				<input type="hidden" name="referrer_user_id" value="{{ $logged_in_user->id }}" >
				<input type="text" name="email" placeholder="Enter an email address" >
			</div>

			
			<div class="small-12 columns">
				<input type="checkbox" class="customize-message" /><label for="checkbox1">Add a personal note to your invitation.</label>
			</div>
			<div class="small-12 columns invite-message" style="display:none;">
				<textarea name="message" rows='6'>I'd like to invite you to Filmkeep,

- {{ $logged_in_user->name }}
				</textarea> 
			</div>
			<div class="small-12 medium-4 columns">
				<span class="spinner"></span><a href="javascript:;" class="button add-invite right" >Invite</a>
			</div>
		
		</div>
	</form>
	<h3>Your Invites</h3>
		<ul class="invites c-list">
		@foreach( $invites as $invite )

		<li class="c-item">
			<span>{{ $invite->email }}</span><br>
			<small>Invite code: <span>{{ $invite->code }}<span> </small> &nbsp;&nbsp;|&nbsp;&nbsp;
			<small>Redeemed: <span>@if ($invite->redeemed == 1) yes @else no @endif <span> </small>
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


	</div>
</div>