<?php
  
class Review extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    // protected $table = 'dates';
     
    
     
    /*
     * A Review belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /*
     * A Review belongs to a film
     */
    public function film()
    {
        return $this->belongsTo('Film');
    }

    /*
     * A Review has many ratings
     */
    public function ratings()
    {
        return $this->hasMany('Rating');
    }
      

    public function getReview($review_id = FALSE)
    {
        if($review_id)
        {

            //Get all data for a specified film by film id
          
            $review = $this::find($review_id);
            $film = $this::find($review_id)->film;
            
            //$ratings = Review::find($review_id)->ratings;
            $ratings = DB::table('ratings as rat')
                        ->select('rat.*','type.*')
                        ->where('rat.review_id', '=' ,$review_id)
                        ->leftJoin('rating_type as type', 'type.id', '=', 'rat.rating_type')
                        ->get();
            $r = $review->toArray() + $film->toArray() + array('ratings'=> $ratings);
            

            return $r;
            
        }  


        
    }

    public function getReviewsFull($user_id, $num=20,$page = 0,$search="", $sort_dir = "desc")
    {
        //Get data for all films from user
        $reviews = DB::table('reviews as rev')
                    ->select('rev.id as review_id','rev.film_id as film_id', 'f.title as title','f.poster_path as poster_path', 'f.backdrop_path as backdrop_path')
                    ->where('rev.user_id', '=', $user_id)
                    ->join('films as f', 'f.id', '=' , 'rev.film_id')
                    ->orderBy('rev.created_at', $sort_dir);

        if( strlen($search) > 0 )
        {
            $reviews = $reviews->where('rev.title', 'LIKE' , '%'.$search.'%');
        }

        if($num)
        {
            
            $reviews = $reviews->take($num);
            $reviews = $reviews->skip($num * $page);
        }

        $reviews = $reviews->get();
        
        foreach($reviews as &$review)
        {
            $result = DB::table('ratings')
                        ->select('rating_type','rating')
                        ->where('review_id', '=' , $review->review_id)
                        ->get();

            $ratings = array();           
            
            foreach($result as $res)
            {
               $ratings[$res->rating_type] =  $res->rating;
            }

            $review->ratings = $ratings;
            $review->slug = Str::slug( $review->title );

        }
        

        return $reviews;
    }

    private function string_to_date($string)
    {
        $current_date = getdate();
        $current_year = $current_date['year'];

        switch(strtolower($string))
        {
            case "just recently":
            $s = time();
            break;

            case "sometime this year":
            $s = strtotime("2 January ".$current_year);
            break;

            case "last year":
            $s = strtotime("2 January ".($current_year - 1));
            break;

            case "several years ago":
            $s = strtotime("2 January ".($current_year - 3));
            break;

        }

        
        $date_watched = new DateTime();
        return $date_watched = DateTime::createFromFormat( 'U', $s);

    }

    private function date_to_string($date)
    {
        $watch_date = strtotime($date);
        $d = getdate($watch_date);
        $today_date = getdate();

        
        $today = time();
        $diff = $today - $watch_date;
        $week = 60 * 60 * 24 *7;

        if($diff < $week){
            return "Just Recently";
        }

        if($d['year'] == $today_date['year'])
        {
            return "Sometime this year";
        }

        if($d['year'] == ($today_date['year'] -1))
        {
            return "Last year";
        }

        if($d['year'] <= ($today_date['year'] -2))
        {
            return "Several years ago";
        }


    }
}