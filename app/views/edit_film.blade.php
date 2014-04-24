<section id="edit-film"  class="expand reveal-modal " data-reveal>
			<div class="row">
					<div class="small-12 columns">
								<h2></h2>
							 
					</div>
			</div>
			
			<form id="edit_film_form" class="custom">
			<div style="height:10px"></div>
				<div class="row">
					<div class="small-12 columns" >
						<input type="hidden" name="review_id" id="review_id" value=""/>
						<input type="hidden" name="user_id" value=""/>
					 
					</div>
					
					
							<div class="small-12 columns">
								<label>When did you watch it?</label>
								<select name="date_watched" class="select-block">
									<option value="Just recently" >Just recently</option>
									<option value="Sometime this year">Sometime this year</option>
									<option value="Last year">Last year</option>
									<option value="Several years ago">Several years ago</option>
								</select>
							</div>
						 
									
						 
							
									<div class="edit-ratings">
									
										

									</div>
													
													
							 
							 <div class="small-12 columns">
									<label>Comments (AKA, your mini review)</label> 
									<textarea style="height:8em;" name="comments" class=""></textarea>
							 </div>
							 <div class="small-12 columns">
									 <input type="submit" id="submit_edit_film" class="large button expand" value="Update Film"/>
							 </div>
							 <div class="small-12 columns" id="edit_results">
								 <p class="ajax-message">Watch this space after you click "Update Film"</p>
							 </div>
						
						
			</div>
			</form>
			<a class="close-reveal-modal">&#215;</a>
		</section>