<?php

class BaseController extends Controller {


	protected $image_path_config;

	protected $logged_in_user;

	protected $show_feed = true;

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
			$this->logged_in_user = Auth::user();
			$notif = new Notification();
			$notifications = $notif->getNotifications($this->logged_in_user->id);
			$new = 0;
			foreach ($notifications as $not) {
				if($not->seen == 0)
				{
					$new++;
				}
			}

			$rating_types = RatingType::getRatingTypes($this->logged_in_user->id);

			View::share('notifications', $notifications);
			View::share('new', $new);
			View::share('rating_types', $rating_types);
			View::share('logged_in_user', $this->logged_in_user);
		}

		View::share('button', $button);
		View::share('show_feed', $this->show_feed);
		//Get image path info for all poster and backdrop images
		$t = new TheMovieDb();
    		$this->image_path_config = $t->getImgPath();
		View::share('image_path_config', $this->image_path_config);


		


		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}