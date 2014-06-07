<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Event::listen('illuminate.query', function($sql){
    var_dump($sql);
});*/

Route::get('test', function(){

    $input = array (
        'referrer_user_id'   => 1,
        'email'     => 'james5@lemonblock.com',
        );
     //make sure the request is valid
        if( 1 == $input['referrer_user_id'] )
        {
            return Response::json(  Invite::addInvite( $input )  );
        }
        else
        {
            return Response::json(array( 'response-type' => 'error', 'response' => 'user is not valid' ));
        }


    /*$payload = array(
        'message' => array(
            'subject' => 'Transactional email via Mandrill',
            'html' => 'It works!',
            'from_email' => 'info@filmkeep.com',
            'to' => array(array('email'=>'james@lemonblock.com'))
        )
    );

    $response = Mandrill::request('messages/send', $payload);*/
});

Route::get('/', array('as' => 'home', 'uses' => (Auth::check() ? 'MainController@getIndex' : 'MainController@getIndexGuest' ) ) );

/*
* 
* Routes within this group require authentication
*
*
*/
Route::group(array('before' => 'Auth'), function()
{
	//Route::get('/', array('as' => 'home', 'uses' => 'MainController@getIndex'));
	Route::get('admin/profile',  array('as' => 'profile', 'uses' => 'ProfileController@getIndex'));

	Route::get('user/logout', array('as' => 'logout', function () {
	    Auth::logout();

	    return Redirect::route('login')
	        ->with('flash_notice', 'You are successfully logged out.');
	}));

    Route::get('/preproduction', array('as' => 'preproduction', 'uses' => 'MainController@getPreproduction') );
    Route::post('/admin/profile/user/update', array('as' => 'user.update', 'uses' => 'UserController@update' ));
});


/*
* 
* Routes within this group require that you are a guest
*
*
*/
Route::group(array('before' => 'guest'), function()
{
    //Route::get('/', array('as' => 'guesthome', 'uses' => 'MainController@getIndexGuest'));
	Route::get('user/login', array('as' => 'login', 'uses' => 'UserController@login'));

	Route::get('user/join', array('as' => 'join',  'uses' => 'UserController@join'));

});

/*
* 
* Filters for guest and authentication
*
*
*/
Route::filter('guest', function()
{
        if (Auth::check()) 
        {
        	$button['text'] = "logout";
            $button['url'] = route('logout');
            return Redirect::to('/'. Auth::user()->username )->with('flash_notice', 'You are already logged in!');
        }


});

Route::filter('Auth', function()
{
        if (Auth::guest())
                return Redirect::route('login')->with('flash_error', 'You must be logged in to view that page!');
});

/*
* 
* Routes for password reset
*
*
*/
Route::get('password/reset', array(
  'uses' => 'PasswordController@remind',
  'as' => 'password.remind'
));

Route::post('password/reset', array(
  'uses' => 'PasswordController@request',
  'as' => 'password.request'
));

Route::get('password/reset/{token}', array(
  'uses' => 'PasswordController@reset',
  'as' => 'password.reset'
));

Route::post('password/reset/{token}', array(
  'uses' => 'PasswordController@update',
  'as' => 'password.update'
));



/*
* 
* Login/Signup routes
*
*
*/
Route::post('user/join', array('uses' => 'UserController@store'));

Route::get('user/loginWithFacebook', array('as' => 'facebooklogin', 'uses' => 'UserController@loginWithFacebook'));
// Route::get('user/loginWithTwitter', array('as' => 'twitterlogin', 'uses' => 'UserController@loginWithTwitter'));
Route::get('user/loginWithGoogle', array('as' => 'googlelogin', 'uses' => 'UserController@loginWithGoogle'));

Route::post('user/login', function () {

        $user = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );
        
        if (Auth::attempt($user , true)) {
            return Redirect::to('/' . Auth::user()->username)
                ->with('flash_notice', 'You are successfully logged in.');
        }
        
        // authentication failure! lets go back to the login page
        return Redirect::route('login')
            ->with('flash_error', 'Your username/password combination was incorrect.')
            ->withInput();
});

Route::post('user/update', array('as' => 'userUpdate', 'uses' => 'AdminController@userUpdate'));


App::missing(function($exception)
{
    return Response::view('404', array(), 404);
});

Route::get('film/{film_id}',  array('uses' => 'FilmController@film'));
Route::get('r/{review_id}',  array('uses' => 'UserController@showReview'));

Route::controller('ajax', 'Ajax');
Route::get('{username}', 'ProfileController@view');
Route::get('{username}/watchlist', 'UserController@showWatchlist');
Route::get('{username}/lists', 'ListController@viewAll');
Route::get('{username}/lists/{list_id}', 'ListController@viewList');
