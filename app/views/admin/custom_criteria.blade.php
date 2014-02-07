<hr>
<h4>Your Custom Criteria</h4>

{{ Form::open(array('url' => 'foo/bar')) }}
    
    {{ Form::text('name' , $value = null, $attributes = array('placeholder' => 'Name of your new criteria')) }}
    <!-- <a data-options="disable-for-touch:true" data-tooltip class='has-tip ' title="If checked, your review will not appear in your friends' feed but will still be visible in your filmkeep"><i class="step fi-info size-36" style="font-size:22px;color:#178FE1;" ></i></a> -->
    {{ Form::text('short_name' , $value = null, $attributes = array('placeholder' => 'Short name for smaller screens')) }}
    <p><em>Use a | to make a label that is split one side to the other, i.e. "clean|dirty"</em></p>
    {{ Form::submit('Add',  $attributes = array('class' => 'button')) }}

{{ Form::close() }}