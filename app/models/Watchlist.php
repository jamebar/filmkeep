<?php
  
class Watchlist extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'watchlist';
     
    
     
    /*
     * A Watchlist belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /*
     * A Watchlist has many films
     */
    public function films()
    {
        return $this->hasMany('Film');
    }

      

    public static function getWatchlist($user_id, $id = FALSE)
    {
       
        $result = DB::table('watchlist as w')
                        ->select('w.id as w_id' , 'w.user_id as user_id', 'f.id as film_id', 'f.title as title', 'f.poster_path as poster_path')
                        ->where('w.user_id', '=' ,$user_id)
                        ->join('films as f', 'f.id', '=', 'w.film_id')
                        ->orderBy('w.list_order', 'asc')
                        ->orderBy('w.created_at', 'asc');
        if($id)
        {
            $result = $result->where('w.id', $id);
        }               
        
        $watchlist = $result->get();

        $wlist = array();
        foreach($watchlist as $w)
        {
            $wlist[$w->film_id] = $w;
        }

        return $wlist;
    }

    public function addWatchlist()
    {
        

        $film_id = Input::get('film_id');
        $user_id = Input::get('user_id');
        
        //check to see if it's already on the watchlist
        $result = $this::where('user_id', $user_id)->where( 'film_id' , $film_id)->first();
        
        
        if(!$result)
        {
            $new_watchlist_item = new Watchlist;
            $new_watchlist_item->film_id = $film_id;
            $new_watchlist_item->user_id = $user_id;
            $new_watchlist_item->save();

            return $new_watchlist_item->id;
        }
        
        return 'duplicate';

    }

    public function removeWatchlist()
    {
        
        $film_id = Input::get('film_id');
        $user_id = Input::get('user_id');
        
        return $this::where('user_id', $user_id)->where( 'film_id' , $film_id)->delete();
    }


}