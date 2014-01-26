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
            $result->where('w.id', $id);
        }               
        /*

        $this->db->select('w.id as w_id, w.user_id as user_id, f.id as film_id, f.title as title, f.poster_path as poster_path');
        $this->db->from('watchlist as w');
        $this->db->join('films as f', 'f.id = w.film_id');
        $this->db->where('w.user_id',$user_id);
        if($id){
            $this->db->where('w.id',$id);
        }
        $this->db->order_by('w.list_order ASC, w.created_at ASC');
        $result = $this->db->get();
        return $result->result_array();
        */
        return $result->get();

    }



}