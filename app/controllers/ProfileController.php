<?php

class ProfileController extends BaseController
{  

	public function getIndex()
	{
		
		return View::make('admin.profile');

	}

	public function view($username)
	{
		$data['page_user'] = User::where('username' , $username)->first();
		$data['watchlist_total'] = Watchlist::where('user_id', $data['page_user']['id'])->count();

		if(!isset($data['page_user']))
			App::abort(404);

		return View::make('profile', $data);

	}
}