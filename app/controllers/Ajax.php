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

}