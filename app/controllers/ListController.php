<?php

class ListController extends BaseController
{    

	public function viewAll($username)
	{	
		$data['page_user'] = User::where('username' , $username)->first();

		$data['lists'] = CustomList::listsWithFilms($data['page_user']);

		if( Auth::check() && Auth::user()->username === $data['page_user']['username'])
		{
			$data['same_user'] = true;
		}
		
		return View::make('lists', $data);

	}

	
}