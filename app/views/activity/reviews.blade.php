<div class="feed-wrapper" style="background-image:url(/img/feed-bg-overlay.png), url({{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][0].$poster_path }}); background-repeat:repeat, no-repeat;background-size:200%;backgroud-position:top center">

	<div class="feed-item small-12 medium-12 columns">
		<div class="row">
			<div class="medium-1 columns remove-right-padding hide-for-small">
				<a class="fa-user" href="/{{ $username }}">
					<img  class=".round-image-tiny"  src="{{ (strlen($profile_pic)>1) ? $profile_pic : url(DEFAULT_PROFILE_PIC) }}">
				</a>
				<div class="activity-date"> 
				<?php 
					$date = new DateTime($created_at);
					//$date->setTimestamp($modified_at);
					echo $date->format('\<\s\p\a\n\>M\<\/\s\p\a\n\> d'); ?>
				</div>
			</div>
			<div class="small-12 medium-2 columns">
				<img src="{{ $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][1].$poster_path }}"/>
			</div>
			<div class="small-12 medium-9 columns">
				<div class=" feed-item-content-wrapper" >
					<div class="feed-item-content">
					<a href="javascript:;" id="{{ $tmdb_id }}" data-id="{{ $review_id }}" class="trailer right"><i class="step fi-video " style="font-size:24px;color:#f4e8d0"></i></a>
						<p class="notes notes-small">
						@if(strlen($comments)>0)
						<span><em class="quote-open">&ldquo;</em></span>{{ Str::limit($comments, 100) }}<span><em class="quote-close">&rdquo;</em></span>
						@endif
						</p>
						<h4 class="@if(strlen($title)>14) small @endif" >{{ $title }}</h4>
						<p>{{ $ratings[1]->label }}</p>
						<div class="rating-line radius">
							<span class="base-line"></span>
			                    		<span class="active-line" style="width: {{ $ratings[1]->rating }}%"></span>
						</div>
					</div>
					<div class="feed-item-bar">
						comments
					</div>
				</div>
			</div>
		</div><!-- end row -->
	</div>
</div>