@section('scripts')
@parent
	<script src="{{ URL::asset('js/custom-type.js') }}"></script>
	
@stop

<div class="row">
	
	<div id="custom-types" class="small-12 columns">
	<p>Create custom criteria.  These will show up for you to use on all reviews, including past ones.</p>
		<ul class="custom-types c-list">
		@foreach( $custom_types as $custom )

		<li class="c-item">
			<span>{{ $custom->label }}</span>
			<div class="right custom_type_controls">
				<a href="javascript:;" class="edit-type" data-typeid="{{ $custom->id }}"><i class="step fi-pencil size-36" style="font-size:22px;color:#178FE1;" ></i></a>
				<a href="javascript:;" data-dropdown="drop{{ $custom->id }}" class="dropdown" ><i class="step fi-x size-36" style="font-size:22px;color:#178FE1;" ></i></a>
				<ul id="drop{{ $custom->id }}" data-dropdown-content class="f-dropdown">
					<li><a class="delete-type" data-typeid="{{ $custom->id }}" href="javascript:;">Yes, delete <i class="step fi-trash " style="font-size:18px;color:#d50606;margin-left:1em" ></i></a></li>
					<li><a href="javascript:;">no, nevermind</a></li>
				</ul>
			</div>
		</li>

		@endforeach


		</ul>

		<form class="custom-type-form">
			<div class="row">
				<div class="small-10 columns">
					<input type="text" name="type_name" placeholder="Add a custom label" >
				</div>
				<div class="small-2 columns">
					<a href="javascript:;" class="add-type right" ><i class="step fi-plus size-36" style="font-size:34px;color:#178FE1;" ></i></a>
				</div>
			
			</div>
		</form>
	</div>
</div>