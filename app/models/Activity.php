<?php
  
class Activity extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'activity';
    protected $guarded = array();
     
    /*
     * An Activity belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
     
    
    /*
     * Get Activity
     * 
     * creates feed from activity of all friends
     * @param array of user ids
     * @return array of events ordered by modified
     */
    public static function getActivity($user_ids, $current_user_id, $date_from = null, $num = 10)
    {
        $activity = Activity::select('*', 'activity.created_at as created_at')
                            ->whereIn('activity.user_id', $user_ids)
                            ->join('users as u','u.id', '=' , 'activity.user_id')
                            ->orderBy('activity.created_at','desc')
                            ->take($num);
                            
        if($date_from !=NULL)
        {
            $activity = $activity->where('activity.created_at', '<', $date_from);
        }
        
       

        $activity = $activity->get();
        
        $events_array = [];

        if(!empty($activity))
        {
            foreach( $activity as $row )
            {
                switch( $row->type )
                {
                    case 'reviews':
                    $res = Review::getReview( $row['related_id'] );
                    $res['username'] = $row->username;
                    $res['name'] = $row->name;
                   
                    
                    break;

                    case 'recommendations':
                    $r  = Recommendation::find($row['related_id']);
                    
                    if($r['user_id_to'] === $current_user_id)
                    {
                        $res = Review::getReviewByFilmId($r['user_id_from'],$r['film_id']);
                        $res['username'] = $row['username'];
                        $res['name'] = $row['name'];
                        $res['recommendation_id'] = $r['id'];
                    }
                    else
                    {
                        $res = FALSE;
                    }

                    break;

                    case 'watchlist':
                    /*$res  = $this->film_model->get_film($row['related_id']);
                    $res['username'] = $row['username'];
                    $res['name'] = $row['name'];
                    $res['fb_id'] = $row['fb_id'];*/
                    break;
                }
                
                if($res)
                {
                    $res['event_type'] = $row->type;
                    $res['updated_at'] = $row->updated_at;
                    $res['created_at'] = $row->created_at;
                    $events_array[] = $res;
                }
                
            }
        }

        return $events_array;
    }
      
}