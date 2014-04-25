<?php

class AdminController extends BaseController
{    

	
    	/**
	 * Login user with facebook
	 *
	 * @return void
	 */
	public function userUpdate() {

		$rules = array(
			'email' => 'required|unique:users,email,' . Input::get('id'),
			'username' => 'required|unique:users,username,' . Input::get('id')

			);

    		$validator = Validator::make(Input::all(), $rules);

    		if ($validator->fails())
		{
			return Redirect::to('/admin/profile')->withErrors($validator);
		}

		$user = User::find( Input::get('id') );

		$user->email = Input::get('email');
		$user->username = Input::get('username');

		$user->save();

		return Redirect::to('/admin/profile')->with('flash_notice', 'Your info has been updated');
	}

}