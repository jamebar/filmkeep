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
    protected $guarded = array();
     
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

    public function removeWatchlist($user_id , $id, $film_id = TRUE)
    {
        
        if($film_id)
        {
            return $this::where('user_id', $user_id)->where( 'film_id' , $id)->delete();
        }
        else
        {
            return $this::where( 'id' , $id)->delete();
        }
    }

    public function sortWatchlist()
    {
        
        $list = Input::get('list');
        

        $i = 1;
        foreach($list as $list_id)
        {
            
            $this::where( 'id' , $list_id )
                    ->update(array('list_order' => $i));
            
            $i++;
        }

        return "success";
    }

    public function addWatchlistSearch()
    {
        

        $tmdb_id = Input::get('tmdb_id');
        $user_id = Auth::user()->id;

        if(strlen($tmdb_id) < 2)
        {
            return false;
        }
        
        
        //get full film info from tmdb.com
        $TheMovieDb = new TheMovieDb();
        $tmdb_info = $TheMovieDb->getFilmTmdb($tmdb_id);

        if(is_array($tmdb_info)){
            $poster_path = (isset($tmdb_info['poster_path'])) ? $tmdb_info['poster_path'] : "";
            $backdrop_path = (isset($tmdb_info['backdrop_path'])) ? $tmdb_info['backdrop_path'] : "";
            $imdb_id = (isset($tmdb_info['imdb_id'])) ? $tmdb_info['imdb_id'] : "";
        }
        

        $film_data = array(
            'title' => $tmdb_info['title'],
            'tmdb_id' => $tmdb_id,
            'poster_path' => $poster_path,
            'backdrop_path' => $backdrop_path,
            'imdb_id' => $imdb_id
        );

        $film = Film::firstOrCreate( $film_data );

        $film_id = $film->id;

        
        //check to see if it's already on the watchlist
        $result = Watchlist::where('user_id' , $user_id)->where('film_id' , $film_id)->exists();
        
        
        if(!$result)
        {
            $data = array(
                    'film_id' => $film_id,
                    'user_id' => $user_id
                );
            
            $w = Watchlist::create($data);
            $t = new TheMovieDb();
            $image_path_config = $t->getImgPath();

            
            $new_film = array (
                'watchlist_id' => $w->id,
                "film_id" => $film_id,
                "poster_path" => $image_path_config['images']['base_url'].$image_path_config['images']['poster_sizes'][1].$poster_path,
                "title" => $tmdb_info['title']
            );

            return $new_film;
        }
        
        return 'duplicate';

    }

}