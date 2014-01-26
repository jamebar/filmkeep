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