<?php

class ProfileController extends BaseController
{  

	public function getIndex()
	{
		$data['custom_types'] = RatingType::getCustomTypes($this->logged_in_user->id);
		
		// calculate time as member
		/*$join_date = strtotime($date);
	        $d = getdate($watch_date);
	        $today_date = getdate();

	        
	        $today = time();
	        $diff = $today - $watch_date;
	        $week = 60 * 60 * 24 *7;*/

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

		return View::make('profile', $data);

	}
}