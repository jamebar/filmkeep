<?php
 
use Carbon\Carbon;
 
class MainController extends BaseController {
 
    public function getIndex()
    {
       	
        $data['films'] = Review::find(143)->film;
        $data['watchlist'] = Watchlist::getWatchlist($this->logged_in_user->id, FALSE, 6);
        //dd($data['watchlist']);
        return View::make( 'main',  $data );
 
    }

    public function getIndexGuest()
    {
    	return View::make( 'mainguest' );
    }
 
}