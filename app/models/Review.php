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
    protected $guarded = array();
    
     
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
      
    public function addReview()
    {
        
        $poster_path =  "";
        $backdrop_path = "";
        $imdb_id = "";
        $date_watched = $this->string_to_date(Input::get('date_watched'));
        $title = Input::get('title');
        
        //get full film info from tmdb.com
        $TheMovieDb = new TheMovieDb();
        $tmdb_info = $TheMovieDb->getFilmTmdb(Input::get('tmdb_id'));
        
        if(is_array($tmdb_info)){
            $poster_path = (isset($tmdb_info['poster_path'])) ? $tmdb_info['poster_path'] : "";
            $backdrop_path = (isset($tmdb_info['backdrop_path'])) ? $tmdb_info['backdrop_path'] : "";
            $imdb_id = (isset($tmdb_info['imdb_id'])) ? $tmdb_info['imdb_id'] : "";
            if(isset($tmdb_info['title']))
            {
                $title = $tmdb_info['title'];
            }
        }
        
        $own = (Input::get('own') === "on") ? 1 : 0;
        $hide  = (Input::get('hide') === "on") ? true : false;
        $user_id = Input::get('user_id');

        $review_data = array(
            'title' => Input::get('title'),
            'source' => Input::get('source'),
            'tmdb_id' => Input::get('tmdb_id'),
            'user_id' => $user_id,
            'date_watched' => $date_watched->format( 'c' ),
            'own' => $own,
            'comments' => Input::get('comments'),
            
        );

        $film_data = array(
            'title' => Input::get('title'),
            'tmdb_id' => Input::get('tmdb_id'),
            'poster_path' => $poster_path,
            'backdrop_path' => $backdrop_path,
            'imdb_id' => $imdb_id
        );
    
        
        // check to see if film is already in database
        $result = Film::where('tmdb_id', $film_data['tmdb_id'])->first();

        if(empty($result))
        {
           
            $film = Film::create( $film_data );
            $film_id = $film->id;

        }
        else
        {
            $film_id = $result->id;
        }
        
        //check to see if review already exists
        $result = Review::where('film_id', $film_id)->where('user_id' , $user_id)->first();

        if(empty($result))
        {

            $review_data['film_id'] = $film_id;
            $review_insert = Review::Create( $review_data );
            
            $review_id = $review_insert->id;

            $ratings = Input::get('rating');
            
            foreach($ratings as $key =>$val)
            {
                Rating::create(array('review_id'=>$review_id,'rating_type'=>$key,'rating'=>$val));
               
            }

            
            //add the event if hide is false
            if(!$hide)
            {
                $data = array(
                    'user_id' => $user_id,
                    'related_id' => $review_id,
                    'type' => 'reviews'
                    
                );
                
                Activity::create($data);
            }
            


        }
        else
        {
            $review_id = $result->id;
        }
        

        /*
        * add recommendation if set
        */
        $recommendations = Input::get('recommend');

        if(strlen($recommendations) >0)
        {
            $recommendations = explode(",", $recommendations);
            foreach($recommendations as $rec)
            {
                if( $rec >0)
                {
                        $data = array(
                        'user_id_to' => $rec,
                        'user_id_from' => $user_id,
                        'film_id' => $film_id,
                        'comments' => ""
                        
                        
                    );
                    
                    Recommendation::addRecommendation($data);
                }
                
            }
        }
        
        return $review_id;
    }

    public static function getReview($review_id = FALSE)
    {
        if($review_id)
        {

            //Get all data for a specified review by review id
          
            $review = Review::select('*','id as review_id')->where('id' , $review_id)->first()->toArray();
            $film = Review::find($review_id)->film->toArray();
            
            //$ratings = Review::find($review_id)->ratings;
            $ratings = DB::table('ratings as rat')
                        ->select('rat.*', 'rat.id as rating_id','type.*', 'type.id as type_id')
                        ->where('rat.review_id', '=' ,$review_id)
                        ->leftJoin('rating_type as type', 'type.id', '=', 'rat.rating_type')
                        ->get();

            $review['date_string'] = self::date_to_string( $review['date_watched'] );
            $r = $review + $film + array('ratings'=> $ratings);
            

            return $r;
            
        }  


        
    }

    public static function getReviewByFilmId($user_id, $film_id)
    {
          
        $review = Review::select('*','reviews.id as review_id')
                    ->where('reviews.user_id', '=', $user_id)
                    ->where('reviews.film_id', $film_id)
                    ->join('films as f', 'f.id', '=' , 'reviews.film_id')
                    ->orderBy('reviews.created_at', 'desc')
                    ->first();
                    

        if(!empty($review))
        {
            
            $ratings = DB::table('ratings as rat')
                        ->select('rat.*', 'rat.id as rating_id','type.*', 'type.id as type_id')
                        ->where('rat.review_id' , $review->id )
                        ->leftJoin('rating_type as type', 'type.id', '=', 'rat.rating_type')
                        ->get();

            $review['date_string'] = self::date_to_string( $review['date_watched'] );
            $r = $review->toArray() + array('ratings'=> $ratings);
            

            return $r;
        }
        
        return $review->toArray();
        
    }


    public function updateReview()
    {
        
        
        $date_watched = $this->string_to_date(Input::get('date_watched'));
        
        $own = (Input::get('own') === "on") ? 1 : 0;

        $review_data = array(
            'source' => Input::get('source'),
            'user_id' => Input::get('user_id'),
            'date_watched' => $date_watched->format( 'c' ),
            'own' => $own,
            'comments' => Input::get('comments'),
            
        );

    
        /* update if id already set 
        *
        */
        

        if(Input::has('review_id')){
           
            $id = Input::get('review_id');
            $update_review = Review::find( $id );
            $update_review->update( $review_data );
            
            $ratings = Input::get('rating');
            
            foreach($ratings as $key =>$val)
            {
                $ids = explode("-", $key);
                $rating_id = $ids[0];
                $type_id = $ids[1];
                $query = Rating::find( $rating_id );
                
                if(isset($val) && strlen($val)>1)
                {
                    if($query->count() == 0) {

                        Rating::create(array('review_id'=>$id,'rating_type'=>$type_id,'rating'=>$val) );
                    
                    } else{

                        $query->update(array('rating'=>$val) ,array('id'=>$rating_id) );
                        
                    }
                }
                
              
            }
            return true;
        }
        
        
    }

    public function getReviewsFull($user_id, $num=20, $page = 0, $search="", $sort_dir = "desc")
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

    public static function getReviewsBasic($user_id, $num=50)
    {
        //Get data for all films from user
        $reviews = DB::table('reviews')
                    ->select('id','title')
                    ->where('user_id' , $user_id)
                    ->orderBy('created_at' , 'desc');

        if($num)
        {
            $reviews = $reviews->take($num);
        }

        $reviews = $reviews->get();
        
        foreach($reviews as &$review)
        {
            $result = DB::table('ratings')
                        ->select('rating_type','rating')
                        ->where('review_id', '=' , $review->id)
                        ->get();

            $ratings = array();           
            
            foreach($result as $res)
            {
               $ratings[$res->rating_type] =  $res->rating;
            }

            $review->ratings = $ratings;

        }

        return $reviews;
    }

    public static function getRatingTypes()
    {
        return RatingType::all();
    }

    private static function string_to_date($string)
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

    private static function date_to_string($date)
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