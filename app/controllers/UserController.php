<?php

class UserController extends BaseController
{    

	
    	/**
	 * Login user with facebook
	 *
	 * @return void
	 */
	public function loginWithFacebook() {

		// get data from input
		$code = Input::get( 'code' );

		// get fb service
		$fb = OAuth::consumer( 'Facebook' );

		// check if code is valid

		// if code is provided get user data and sign in
		if ( !empty( $code ) ) {

			// This was a callback request from google, get the token
			$token = $fb->requestAccessToken( $code );

			// Send a request with it
			$result = json_decode( $fb->request( '/me' ), true );

			//search for user in database by facebook id
			if(isset($result['id']))
			{
				$user = User::where('fb_id' , $result['id'] )->first();

				//print_r($user);
				//Auth::loginUsingId($user['id']);
				if($user)
				{
					Auth::login( $user , true);
			        
				        if (Auth::check())
					{
						//add profile pic if doesn't exist
						if( strlen($user->profile_pic) < 2)
						{
							$user->profile_pic = "http://graph.facebook.com/".$result['username']."/picture?width=250&height=250";
							$user->save();
						}
					    	return Redirect::route('home')
	                			->with('flash_notice', 'You are successfully logged in.');
					}
				}
				else
				{
					//add user to database
					// store
					$user = new User;
					$user->name       	= $result['name'];
					$user->username   	= $result['username'];
					$user->email      	= $result['email'];
					$user->fb_id 	  	= $result['id'];
					$user->profile_pic  	= "http://graph.facebook.com/".$result['username']."/picture?width=250&height=250";
					$user->save();

					Auth::login( $user , true);

					return Redirect::route('home')
	                			->with('flash_notice', 'Welcome to Filmkeep '.$result["name"]);
				}
				
				
				
			}
			
			
		}
		// if not ask for permission first
		else {
			// get fb authorization
			$url = $fb->getAuthorizationUri();

			// return to facebook login url
			return Response::make('',302)->header('Location',(string)$url);
		}

	}

	/**
         * Login user
         *
         * @return void
         */
        public function loginWithTwitter() {

                // get data from input
                $code = Input::get( 'oauth_token' );
                $oauth_verifier = Input::get( 'oauth_verifier' );

                // get fb service
                $twitterService = OAuth::consumer( 'Twitter' );

                // check if code is valid

                // if code is provided get user data and sign in
                if ( !empty( $code ) ) {

                	$token = $twitterService->getStorage()->retrieveAccessToken('Twitter');

                        // This was a callback request from google, get the token
                        $twitterService->requestAccessToken( $code, $oauth_verifier, $token->getRequestTokenSecret() );

                        // Send a request with it
                        $result = json_decode( $twitterService->request( 'account/verify_credentials.json') );

                        // try to login
                       // $user = User::where('fb_id' , $result['id'] )->first();
                        // get user by twitter_id
                        $user = User::where('twitter_id' , $result->id )->first();

                        // check if user exists
                        if ( $user ) {
                                // login user
                                Auth::login( $user , true);

                                return Redirect::route('home')
	                			->with('flash_notice', 'You are successfully logged in.');

                        }
                        else {
                                // FIRST TIME TWITTER LOGIN

                                // create new username
                                $user = new User;
				$user->name          = $result->name;
				$user->username      = $result->screen_name;
				$user->twitter_id    = $result->id;
				$user->profile_pic    = $result->profile_image_url;
				$user->save();

                                // login user
                                Auth::login( $user , true);

                                // build message with some of the resultant data
                                $message_notice = 'Welcome to Filmkeep, your account is created.';

                                // redirect to game page
                                return Redirect::route( 'home' )
                                        ->with( 'flash_notice', $message_notice );

                        }
                }
                // if not ask for permission first
                else {

                    // extra request needed for oauth1 to request a request token :-)
                    $token = $twitterService->requestRequestToken();
                    $url = $twitterService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);

                        // return to twitter login url
                        return Response::make('',302)->header('Location',(string)$url);

                }

        }


	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'fullname'       => 'required',
			'email'      => 'required|email',
			'password' => 'required|min:6'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {

			return Redirect::route('join')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

			$user = User::where('email' , Input::get('email') )->first();

			if(!$user)
			{
				// store
				$user = new User;
				$user->name       = Input::get('fullname');
				$user->email      = Input::get('email');
				$user->password = Hash::make(Input::get('password'));
				$user->save();

				Auth::login($user);

				// redirect
				Session::flash('flash_notice', 'Welcome to Filmkeep!');
				return Redirect::route('home');
			}
			else
			{	
				Session::flash('flash_error', 'A user with this email already exists.');
				return Redirect::route('join');

			}
			
		}
	}

	public function showReview($review_id)
	{	
		$r = new Review();
		$data['review'] = $r->getReview($review_id);
		$data['page_user'] = $r::find($review_id)->user;
		$data['watchlist'] = Watchlist::getWatchlist(Auth::user()->id);
		$data['page_title'] = $data['review']['title'];
		

		return View::make('review', $data);

	}

	public function showWatchlist($username)
	{	
		$data['page_user'] = User::where('username' , $username)->first();
		$data['watchlist'] = Watchlist::getWatchlist($data['page_user']['id']);
		if(Auth::user()->username === $data['page_user']['username'])
		{
			$data['same_user'] = true;
		}
		return View::make('watchlist', $data);

	}

	public function login()
	{
		return View::make('login');
	}

	public function join()
	{
		return View::make('join');
	}
}