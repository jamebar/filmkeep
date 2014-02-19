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
        
           
        return Response::json(array('total'=> $total_reviews, 'items'=>$filtered_reviews->toArray()));
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


    public function getAllUserReviews()
    {
       
        $user_id = Input::get('user_id');
        return Response::json( Review::getReviewsBasic($user_id,50) );
    }

    /**
     * Get Film
     * 
     * Handles the Ajax call to fetch a single review 
     * 
     */
    public function postGetReview()
    {

        $id = Input::get('id');
        $f = Review::getReview( $id );
        
        echo json_encode($f);
        
    }

    /**
     * Create
     * 
     * Handles the Ajax call to create individual film data 
     * 
     */
    public function postCreateReview()
    {
        
        $new_review = new Review();
        $new_id = $new_review->addReview();
        
        if($new_id)
        {
            
           return Response::json( $new_id );
        }
        else
        {
            return Response::json("fail");
        }
        
    }

    /**
     * Update Review
     * 
     * Handles the Ajax call to update individual review data 
     * 
     */
    public function postUpdateReview()
    {
        
        $update_review = new Review();
        
        if( $update_review->updateReview() )
        {

            return Response::json("success");
        }
        else
        {
            return Response::json("fail");
        }
        
    }

    /**
     * Search Users
     * 
     * Handles the Ajax call to autocomplete users recommendations
     * 
     */
    public function postSearchUsers()
    {
        
        
        $q = Input::get('q');
        $f = User::where( 'name' , 'LIKE' , '%'.$q.'%' )->get();
        
       return Response::json( $f );
        
    }

    /**
     * Get Activity Feed
     * 
     *  
     * 
     */
    public function postGetFeed()
    {
        $logged_in_user = Auth::user()->toArray();
        $date_from = null;

        
        if(Input::has('last_date')){
            $date_from = Input::get('last_date');
        }
        
        //$friendIds = $this->session->userdata('friendIds');
        $friendIds = Follow::getFollowingIds($logged_in_user['id']);
        //return Response::json( $friendIds );
        $friendIds[] = $logged_in_user['id'];
        $activity = Activity::getActivity($friendIds, $logged_in_user['id'], $date_from['date']);

        $watchlist = Watchlist::getWatchlist( $logged_in_user['id'] );
        $wlist = array();

        foreach($watchlist as $w)
        {
            $wlist[$w->film_id] = $w;
        }
        
        
        $feed_items  = array(); 
        $last_date = '';  
        if(!empty($activity))
        {   

            
            foreach($activity as $e)
            {
                 $e['image_path_config']  = $this->image_path_config;
                 $e['logged_in_user'] = $logged_in_user;
                 $e['watchlist'] = $wlist;

                 //check to see if logged in user has reviewed this film
                 $user_review = Review::getReviewByFilmId($logged_in_user['id'], $e['film_id']);
                 if(!empty($user_review))
                    $e['user_review'] = $user_review;

                if($e['event_type'] == 'reviews')
                {
                     $feed_items[] = View::make('activity.'.$e['event_type'], $e)->render();
                
                    $last_date = $e['created_at'];
                }
                
            }
             //$feed_items;
        }
        
        return Response::json( array('items'=>$feed_items, 'last_date'=> $last_date));
    }

    public function postAddRemoveFollow()
    {
        $follow_user_id = Input::get('follow_user_id');
        $action = Input::get('action');


        if($action == "add")
        {

            return Response::json( follow::addFollow(Auth::user()->id, $follow_user_id) );

        }
        else 
        {
            return Response::json( follow::removeFollow(Auth::user()->id, $follow_user_id) );
        }

    }

    /*** CUSTOM CRITERIA/TYPE METHODS ****/
    
    public function postAddCustomType()
    {
        $name = Input::get('name');

        return RatingType::addCustomType($this->logged_in_user->id, $name);
    }

    public function postUpdateCustomType()
    {
        $name = Input::get('name');
        $id = Input::get('id');

        return Response::json( RatingType::updateCustomType($this->logged_in_user->id, $name, $id) );
    }

    public function postDeleteCustomType()
    {
        $id = Input::get('id');

        return RatingType::deleteCustomType($this->logged_in_user->id, $id);
    }
}