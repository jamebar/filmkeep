<?php

class BaseController extends Controller {


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		$button['text'] = "login";
		$button['url'] = route('login');

		if(Auth::check())
		{
			$button['text'] = "logout";
			$button['url'] = route('logout');
		}
		View::share('button', $button);

		//Get image path info for all poster and backdrop images
		$t = new TheMovieDb();
    		$image_path_config = $t->getImgPath();
		View::share('image_path_config', $image_path_config);

		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}