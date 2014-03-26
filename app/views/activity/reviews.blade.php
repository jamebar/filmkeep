<div class="feed-item small-12 medium-6 columns">
	<div class="row">
		<div class="medium-2 columns remove-right-padding hide-for-small">
			<a class="fa-user" href="/{{ $username }}">
				<img  class=".round-image-tiny"  src="{{ (strlen($profile_pic)>1) ? $profile_pic : url(DEFAULT_PROFILE_PIC) }}">
			</a>
			<div class="activity-date"> 
			<?php 
				$date = new DateTime($created_at);
				//$date->setTimestamp($modified_at);
				echo $date->format('M d'); ?>
			</div>
		</div>
		<div class="small-12 medium-10 columns">
			<div class=" feed-item-content-wrapper" style="background-image:url(/img/feed-bg-overlay.png), url({{ $image_path_config['images']['base_url'].$image_path_config['images']['backdrop_sizes'][2].$backdrop_path }}); background-repeat:repeat, no-repeat;background-size:cover;">
				<div class="feed-item-content">
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