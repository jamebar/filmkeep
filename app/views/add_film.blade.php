<section id="add-film"  class="expand reveal-modal" data-reveal>
  <div class="row">
	  <div class="small-12 columns">
			<h2 alt="Add a film review">Add a film review</h2>
			
	  </div>
  </div>
  
  <form id="add_film_form" class="custom">
  <div style="height:10px"></div>
	<div class="row">
	  <div class="small-12 columns " id="film_title">
		<input type="text" name="title" class="rtautocomplete"  placeholder="Start typing film title">
		<input type="hidden" name="tmdb_id" id="tmdb_id" value=""/>
		<input type="hidden" name="user_id" value="{{ $logged_in_user->id }}"/>
		<div id="autocomplete_loader" class="small-12" ></div>
		<div id="film_search_message" class="small-12" ></div>
	  </div>
	  
	  <div id="add_film_step2" style="display:none;">
		  <div class="small-12 columns">
			<label>When did you watch it?</label>
			<select name="date_watched" class="select-block">
				<option value="Just recently" selected>Just recently</option>
				<option value="Sometime this year">Sometime this year</option>
				<option value="Last year">Last year</option>
				<option value="Several years ago">Several years ago</option>
			</select>
		  </div>
		  
		  <div class="small-12 columns">
		  
		  @if (isset($rating_types))  
				@foreach($rating_types as $r)
					 	
					  <div class="small-12 columns">
						<label class="show-for-medium-up"><?php 
						
						if(strpos($r->label, '|') >-1){
							$l = explode("|",$r->label);
							echo $l[0]."<span class='label-right'>".$l[1]."</span>";
						}else {
							echo $r->label;  
						}?></label>
						<label class="show-for-small"><?php 
						
						if(strpos($r->label_short, '|') >-1){
							$l = explode("|",$r->label_short);
							echo $l[0]."<span class='label-right'>".$l[1]."</span>";
						}else {
							echo $r->label_short; 
						}?></label>
						<div class="noUiSlider" data-rtype="{{ $r->id }}" name="rating[{{$r->id }}]"></div>
						<input name="rating[{{ $r->id }}]" type="hidden" value="50" >

					  </div>
					  
					  
		   		@endforeach        
		   @endif
		   <div class="small-12 columns">
		  <label for="hide_checkbox">
		    <input name="hide" type="checkbox" id="hide_checkbox" >
		    <span class="custom checkbox"></span> Hide from feed? <a data-options="disable-for-touch:true" data-tooltip class='has-tip ' title="If checked, your review will not appear in your friends' feed but will still be visible in your filmkeep"><i class="step fi-info size-36" style="font-size:22px;color:#c8bba1;" ></i></a>
		  </label>
			
		  </div>
		   <div class="small-12 columns">
			  <label>Comments (AKA, your mini review)</label> 
			  <textarea style="height:8em;" rows="4"  name="comments" class=""></textarea>
		   </div>
		   
		    <div class="small-12 columns rec-input" id="film_rec">
		    	<label>Recommend this film to a friend ( <em>enter nothing to skip</em> )</label> 
			<input type="text" name="recommend_type" class="recautocomplete"  placeholder="Type a friend's name">
			<input type="hidden" name="recommend" id="recommend_values" value="">
			<div class="rec-con"></div>
		</div>
		  
		   <div class="small-12 columns">
			   <input type="submit" id="submit_add_film" class="large button expand" value="Add Film"/>
		   </div>
		   <div class="small-12 columns" id="rt_results">
			 <p class="ajax-message">Watch this space after you click "Add Film"</p>
		   </div>
		</div><!-- end add_film_step2 -->
		
  </div>
  </form>
  <a class="close-reveal-modal">&#215;</a>
</section>