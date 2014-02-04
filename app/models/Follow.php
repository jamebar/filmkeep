<?php
  
class Follow extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'follow';
    protected $guarded = array();
     
    /*
     * A follow belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /*
     * Get all users who supplied user is following
     * @return array with id's as array keys
     */
    public static function getFollowingIds($user_id)
    {
       
        $follow = Follow::where('user_id', $user_id)->select('user_id_follow')->get();
        $flist = array();

        foreach($follow as $f)
        {
            $flist[] = $f->user_id_follow;
        }

        return $flist;
    }

    /*
     * Get all users who supplied user is following
     * @return array with id's as array keys
     */
    public static function getFollowing($user_id)
    {
       
       return Follow::select('u.*')
                        ->where('user_id', $user_id)
                        ->join('users as u', 'u.id', '=', 'follow.user_id')
                        ->take(100)
                        ->get();
       
       
    }
      
    /*
     * Get all users who are following supplied user
     * 
     */
    public static function getFollowers($user_id)
    {
       
       return Follow::where('user_id_follow', $user_id)->get();
       
    }

    public static function addFollow($user_id, $follow_user_id)
    {
        if($user_id == $follow_user_id)
            return false;
        
        //check to see if it's already on the watchlist
        $result = Follow::firstOrCreate(array('user_id' => $user_id, 'user_id_follow' => $follow_user_id));
        
        
        return $result;

    }

    public static function removeFollow($user_id, $follow_user_id)
    {
        
        return Follow::where('user_id', $user_id)->where( 'user_id_follow' , $follow_user_id)->delete();
        
    }

    

    

}