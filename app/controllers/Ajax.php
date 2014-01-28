<?php

class Ajax extends BaseController 
{      

    /**
     * Get Filtered Reviews
     * 
     *  
     * 
     */
    public function getFilteredReviews()
    {
        
        $user_id = Input::get('page_user_id');
        $num = Input::get('num');
        $page = Input::get('page');
        $search = Input::get('search_query');
        $sort_dir = Input::get('sort_dir');

        
        $review = new Review();
        $filtered_reviews = $review->getReviewsFull($user_id, $num, $page, $search, $sort_dir);
        $total_reviews = Review::where('user_id', $user_id)->count();
        
           
        return Response::json(array('total'=> $total_reviews, 'items'=>$filtered_reviews));
    }

    /*
    *   Removes or adds item from the watchlist via the feed or a review page
    *   accepts the action (add or remove) and the film id
    */
    public function postAddRemoveWatchlist()
    {
        
        $action = Input::get('action');
        $film_id = Input::get('film_id');

        if(strlen($film_id)>1)
        {
            $watchlist = new Watchlist();

            if($action == "add")
            {

                return Response::json( $watchlist->addWatchlist() );

            }
            else 
            {
                return Response::json( $watchlist->removeWatchlist(Auth::user()->id, $film_id, TRUE) );
            }
            
        }
        else 
        {
            return Response::json( "0" );
        }
        
    }

    /*
    *   Sorts the watchlist
    *   accepts an array of watchlist id's in the desired order
    */
    public function postSortWatchlist()
    {
        
        $list = Input::get('list');

        if(count($list)>0)
        {
            $watchlist = new Watchlist();
            return Response::json( $watchlist->sortWatchlist() );
        }
        else
        {
            return Response::json( "false" );
        }
    }

    /*
    *   Remove item from the watchlist via the watchlist page
    *   accepts watchlist item id
    */
    public function postRemoveFromWatchlist()
    {
      
        $w_id = Input::get('id');
        $watchlist = new Watchlist();
        return Response::json( $watchlist->removeWatchlist( Auth::user()->id, $w_id, FALSE) ); 
        
    }


    public function postSearchTmdb()
    {
        $query = Input::get('query');
        $search = new TheMovieDb();
        return Response::json( $search->searchTmdb( $query ) );

    }

    public function postAddWatchlistSearch()
    {
        $watchlist = new Watchlist();
        $results = $watchlist->addWatchlistSearch();
        return Response::json( $results );
            
    }

    public function postFilmTrailer()
    {    
        $tmdb_id = Input::get('tmdb_id');
        $TheMovieDb = new TheMovieDb();
        $trailer = $TheMovieDb->getFilmTrailer($tmdb_id);
        return Response::json( $trailer );
    }
}