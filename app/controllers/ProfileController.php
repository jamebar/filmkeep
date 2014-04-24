<?php

class ProfileController extends BaseController
{  

	public function getIndex()
	{
		$data['custom_types'] = RatingType::getCustomTypes($this->logged_in_user->id);
		$data['user'] = Auth::user();
		// calculate time as member
		$join_date = strtotime($this->logged_in_user->created_at);

	        $today = time();
	        $diff = $today - $join_date;
	        $week = 60 * 60 * 24 * 7;

	        $diff = $diff  / 60 / 60 / 24;
	        $unit = "days";

	        if( $diff > 30 )
	        {
	        	$diff = $diff / 30;
	        	$unit = "months";

	        	if( $diff > 12 )
		        {
		        	$diff = $diff / 12;
		        	$unit = "years";
		        }
	        }

	        

	        $data['diff'] = floor( $diff );
	        $data['unit'] = $unit;

		return View::make('admin.profile', $data);

	}

	public function view($username)
	{
		$data['page_user'] = User::where('username' , $username)->first();
		$data['watchlist_total'] = Watchlist::where('user_id', $data['page_user']['id'])->count();
		if(Auth::check())
		{
			$data['following'] = Follow::getFollowingIds(Auth::user()->id);
		}
		
		$data['page_user_following'] = Follow::getFollowingIds($data['page_user']['id']);

		if(!isset($data['page_user']))
			App::abort(404);

		$r = new Review();
		$latest_review = $r->getReviewsFull($data['page_user']['id'], $num=1);
		
		if(count($latest_review) <1)
		{
			$data['latest_review_backdrop_large'] = DEFAULT_BACKGROUND_PIC;
			$data['latest_review_backdrop_small'] = DEFAULT_BACKGROUND_PIC;
		}
		else
		{
			$data['latest_review_backdrop_large'] = $this->image_path_config['images']['base_url'].$this->image_path_config['images']['backdrop_sizes'][2].$latest_review[0]['backdrop_path'];
			$data['latest_review_backdrop_small'] = $this->image_path_config['images']['base_url'].$this->image_path_config['images']['backdrop_sizes'][1].$latest_review[0]['backdrop_path'];

		}
		
		return View::make('profile', $data);

	}
}