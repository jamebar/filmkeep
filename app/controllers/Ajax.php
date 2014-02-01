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


    /**
     * Get Comments
     * 
     * Handles the Ajax call to get  comments
     * 
     */
    public function postGetComments()
    {
       
        
        $object_id = Input::get('object_id');
        $type = Input::get('object_type');
        $num = Input::get('num');
        if(strlen($object_id) > 0)
        {
            
            $c = Comment::getComments($object_id, $type, $num);
            foreach($c as &$com)
            {
                if(strlen($com->profile_pic) < 1)
                    $com->profile_pic = DEFAULT_PROFILE_PIC;
            }
            return Response::json($c);
        }
        else
        {
            return Response::json('false');   
        }
        
        
    }

    /**
     * add Comment
     * 
     * Handles the Ajax call to add  comments
     * 
     */
    public function postAddComment()
    {
       
        
        $user_id = Input::get('user_id');
        $object_id = Input::get('object_id');
        $object_type = Input::get('object_type');
        $comment = Input::get('comment');
        $spoiler = 0;
        if(Input::has('spoiler'))
        {
            $spoiler = 1;
        }
        if(strlen($user_id) > 0)
        {

            $c = Comment::addComment($user_id, $object_id, $object_type, $comment, $spoiler);
            return Response::json(array('result'=> $c,
                                        'username' => Auth::user()->username, 
                                        'name' => Auth::user()->name,
                                        'profile_pic' => Auth::user()->profile_pic 
                                         ));
        }
        else
        {
            return Response::json(array('result' => 'false'));   
        }
        
        
    }

    /**
     * Delete Comments
     * 
     * Handles the Ajax call to delete  comments
     * 
     */
    public function postDeleteComment()
    {
       
        
        $id = Input::get('id');
        $user_id = Input::get('user_id');
        
        if(Auth::user()->id === $user_id)
        {
            $c  = new Comment();
            return Response::json( $c->deleteComment( $id )); 
        }
        else
        {
            echo json_encode('false');   
        }
        
        
    }

    public function postClearNotifications()
    {
        $user_id = Input::get('user_id');
        $n = new Notification();
        $result = $n->clearNotifications($user_id);
        if($result)
        {
            return Response::json( array('result' => 'success' ) );
        }
        else
        {
            return Response::json( array( 'result' => 'false' ) );
        }
        
    }
}