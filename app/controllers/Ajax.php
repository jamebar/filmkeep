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
                return Response::json( $watchlist->removeWatchlist() );
            }
            
        }
        else 
        {
            return Response::json( "0" );
        }
        
    }
}