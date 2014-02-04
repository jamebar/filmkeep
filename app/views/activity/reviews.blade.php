<div class="feed-item">
									 
		<div class="feed-padding">
				<div class="row">
					<div class="small-10 columns">
						<a class="fa-user left" href="/{{ $username }}">
							<img width="50" height="50" class="round-image"  src="{{ (strlen($profile_pic)>1) ? $profile_pic : url(DEFAULT_PROFILE_PIC) }}">
						</a>
						<div>
							<h6 class="subheader">{{ $name }} </h6>
							<h6 class="subheader">reviewed</h6>
						</div>
					</div>
				
					<div class="small-2 columns">
						<span class="activity-date"> <?php 
							$date = new DateTime($created_at);
							//$date->setTimestamp($modified_at);
							echo $date->format('M d'); ?>
						</span>
					</div>    
				</div>
		</div><!-- feed padding -->
		<hr style="margin:0px;padding:0px;">
		<div class="feed-padding">
				<div class="row">
					<div class="small-4 columns">
					<a class="fa-poster  " href="/r/{{ $review_id."-".Str::slug($title) }}"><img src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][2].$poster_path }}" /> </a>
					</div>
					<div class="small-8  columns">
						<h4><a href="/r/{{ $review_id."-".Str::slug($title) }}">{{ $title }}</a></h4>
						<span class="show-for-medium-up">
								 <p>{{ $ratings[0]->label }}</p>
								<div class="progress  info "><span class="meter" style="width: {{ $ratings[0]->rating }}%"></span></div>
						</span>
						<p class="show-for-medium-up">{{ $ratings[1]->label }}</p>
						<p class="show-for-small">{{ $ratings[1]->label_short }}</p>
						<div class="progress  info radius"><span class="meter" style="width: {{ $ratings[1]->rating }}%"></span></div>
						<p>{{ $ratings[3]->label }}</p>
						<div class="progress  info "><span class="meter" style="width: {{ $ratings[3]->rating }}%"></span></div>
						<span class="show-for-medium-up">
								<p>{{ $ratings[4]->label }}</p>
								<div class="progress  info "><span class="meter" style="width: {{ $ratings[4]->rating }}%"></span></div>
						</span>
					</div>
				</div>
		</div><!-- end feed-padding -->
		<hr style="margin:0px;padding:0px;">
		
		<div class="feed-padding">
				<div class="row">
					<div class="small-12 columns" id="">

							<a href="javascript:;" id="{{ $tmdb_id }}" data-id="{{ $review_id }}" class="load-trailer"><i class="step fi-video " style="font-size:24px;color:#aaa;"></i></a>
							<a href="javascript:;" class="comment-icon"><i class="show-for-small step fi-comment " style="font-size:21px;color:#aaa;"></i> <span class="hide-for-small">Comment</span></a>
							<?php if($logged_in_user['username'] !== $username):?>
								 	
									<a href="javascript:;" class="button tiny right add-remove-watchlist  @if(array_key_exists($film_id, $watchlist)) {{ "onlist" }} @endif" data-film_id="{{ $film_id }}" data-user_id="{{ $logged_in_user['id'] }}"> <i class="step fi-check size-11" style="font-size:11px;color:#fff;"></i><i class="step fi-plus size-11" style="font-size:11px;color:#fff;"></i> <span></span></a>
									
									@if(empty($user_review))

										<a href="javascript:;" class="button tiny right add-this" data-title="{{ $title }}" data-tmdbid="{{ $tmdb_id }}" style="margin-right:5px;"><i class="step fi-plus size-11" style="font-size:11px;color:#fff;"></i> review this</a>
									@endif
							<?php else: ?>
									<a href="javascript:;" class="tiny right  edit-review" data-id="{{ $review_id }}" data-film_id="{{ $film_id }}" data-user_id="{{ $logged_in_user['id'] }}"> <i class="step fi-pencil size-14" style="font-size:14px;color:#ccc;"></i> edit </a>
							<?php endif; ?>
							<div class="row" id="{{ $review_id }}_con">
								<div id="" class="trailer-con small-12 columns"></div>
							</div>
					</div>
				</div>
		</div>
		<hr style="margin:0px;padding:0px;">
		<div class="feed-padding hide comment-con">
	            <div class="row comment-section">
	                <div class="small-12 columns comment-box" data-ctype="tease" id="reviews-{{ $review_id }}"></div>
	                <div class="small-12 columns">
	                    <form class="comment_form" data-id="{{ $review_id }}" data-type="reviews">
	                        <textarea name="comment"  placeholder="Add a comment"></textarea>
	                        <div class="spoiler-check">
	                            <label><span class="show-for-medium-up">contains spoilers</span><span class="show-for-small">spoilers</span></label>
	                            <input type="checkbox" name="spoiler" >
	                        </div>
	                        <input type="submit" id="submit_comment" class="right button tiny secondary" value="Add Comment"/>
	                    </form>
	                </div>
	            </div>
	        </div>
</div><!-- end row -->