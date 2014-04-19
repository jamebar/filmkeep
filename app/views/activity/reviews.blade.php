<div class="feed-item small-12 medium-6 columns">
	<div class="row">
		<div class="small-12 columns">
			<div class=" feed-item-content-wrapper" style="background-image:url(/img/feed-bg-overlay.png), url({{ $image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][2].$backdrop_path }}); background-repeat:repeat, no-repeat;background-size:cover;">
				<h4 class="@if(strlen($title)>14) small @endif" ><a href="/r/{{ $id }}">{{ $title }}</a></h4>
			</div>
			<div class="feed-item-content">
				<div class="profile-info-center">
					<img src="@if( strlen($profile_pic ) > 0 ) {{ $profile_pic }} @else {{ DEFAULT_PROFILE_PIC }} @endif"/>
					<p>{{$name}}</p>
				</div>
				<p class="notes notes-small">
				@if(strlen($comments)>0)
				<span><em class="quote-open">&ldquo;</em></span>{{ Str::limit($comments, 100) }}<span><em class="quote-close">&rdquo;</em></span>
				@endif
				</p>
				
				<p>{{ $ratings[1]->label }}</p>
				<div class="rating-line radius">
					<span class="base-line"></span>
	                    		<span class="active-line" style="width: {{ $ratings[1]->rating }}%"></span>
				</div>
				<div class="feed-item-bar">
					<a href="javascript:;" class="comment-icon"><i class="fi-comment"></i> comments</a>
					<div class="right">
						@if($logged_in_user['username'] === $username)
						<a href="javascript:;" class="edit-review" data-id="{{ $review_id }}" data-film_id="{{ $film_id }}" data-user_id="{{ $logged_in_user['id'] }}"><i class="fi-pencil"></i> edit</a>
						@else
						<a href=""><i class="fi-plus"></i>  watchlist</a>
							@if(empty($user_review))

							<a href="javascript:;" class="add-this" data-title="{{ $title }}" data-tmdbid="{{ $tmdb_id }}"><i class="fi-page-add"></i> review</a>
							@endif

						
						
						
						@endif
						<!--<a href=""><i class="fi-eye"></i> full context</a>-->

					</div>
				</div>
			</div>
			
			<div class="feed-padding hide comment-con">
		            <div class="row comment-section">
		                <div class="small-12 columns comment-box" data-ctype="tease" id="reviews-<?php echo $review_id;?>"></div>
		                <div class="small-12 columns">
		                    <form class="comment_form" data-id="<?php echo $review_id;?>" data-type="reviews">
		                        <textarea name="comment"  placeholder="Add a comment"></textarea>
		                        <input type="submit" id="submit_comment" class="right button tiny secondary" value="Add Comment"/>
		                    </form>
		                </div>
		            </div>
		        </div>
		</div>
	</div><!-- end row -->
</div>

<!--
<div class="activity-date"> 
<?php 
	$date = new DateTime($created_at);
	//$date->setTimestamp($modified_at);
	echo $date->format('M d'); ?>
</div>
-->