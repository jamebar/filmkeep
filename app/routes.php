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
    $review = new Review();
    dd($review->getReviewsFull(1));
    $reviews = Review::with('ratings')->select('reviews.id as id','reviews.film_id as film_id', 'f.title as title','f.poster_path as poster_path', 'f.backdrop_path as backdrop_path')
                    ->where('reviews.user_id', '=', 1)
                    ->join('films as f', 'f.id', '=' , 'reviews.film_id')
                    ->orderBy('reviews.created_at', 'DESC')
                    ->take(5)
                    ->get()->toArray();
                    
        
        foreach($reviews as &$review)
        {
            
            $ratings = array();
            foreach($review['ratings'] as $res)
            {
              $ratings[$res['rating_type']] =  $res['rating'];    
            }

            $review['ratings'] = $ratings;
            $review['slug'] = Str::slug( $review['title'] );

        }

        dd($reviews);
});

Route::group(array('before' => 'Auth'), function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'MainController@getIndex'));
	Route::get('admin/profile',  array('as' => 'profile', 'uses' => 'ProfileController@getIndex'));

	Route::get('user/logout', array('as' => 'logout', function () {
	    Auth::logout();

	    return Redirect::route('login')
	        ->with('flash_notice', 'You are successfully logged out.');
	}));

    

});

Route::group(array('before' => 'guest'), function()
{
    Route::get('/', array('as' => 'guesthome', 'uses' => 'MainController@getIndexGuest'));
	Route::get('user/login', array('as' => 'login', 'uses' => 'UserController@login'));

	Route::get('user/join', array('as' => 'join',  'uses' => 'UserController@join'));

});

Route::filter('guest', function()
{
        if (Auth::check()) 
        {
        	$button['text'] = "logout";
            $button['url'] = route('logout');
            return Redirect::route('home')->with('flash_notice', 'You are already logged in!');
        }


});

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

Route::filter('Auth', function()
{
        if (Auth::guest())
                return Redirect::route('login')->with('flash_error', 'You must be logged in to view that page!');
});


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
            return Redirect::route('home')
                ->with('flash_notice', 'You are successfully logged in.');
        }
        
        // authentication failure! lets go back to the login page
        return Redirect::route('login')
            ->with('flash_error', 'Your username/password combination was incorrect.')
            ->withInput();
});




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
