<?php
  
class Notification extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
    protected $guarded = array();
    

    public static function addNotification($data)
    {
        
        return Notification::create( $data );
        
    }


    /**
     * Get Notifications
     * 
     * creates feed from events of all friends
     * @param array of user ids
     * @return array of events ordered by modified
     */
    public function getNotifications($current_user_id, $num = 10)
    {
        $result = DB::table('notifications as n')
                ->select('n.*', 'u.*')
                ->where('n.to_user_id', $current_user_id)
                ->join('users as u', 'u.id' , '=' , 'n.from_user_id')
                ->orderBy('n.created_at' , 'desc')
                ->take($num)
                ->get();

        $notifications_array = [];

        if(count($result) > 0)
        {
            foreach($result as $row)
            {
                switch($row->object_type)
                {
                    case 'reviews':

                    $res = DB::table('reviews as r')
                                ->select('r.*', 'u.username as review_username')
                                ->where('r.id' , $row->object_id)
                                ->join('users as u', 'u.id', '=', 'r.user_id')
                                ->first();

                    $res->username = $row->username;
                    $res->name = $row->name;
                    
                    break;

                    case 'recommendations':
                    $res = false;
                    break;
                    /*
                    case 'recommendations':

                    $r  = $this->recommendations_model->get_recommendation_by_id($row['object_id']);
                    if($r['user_id_to'] === $current_user_id)
                    {
                        $res = $this->review_model->get_reviews_by_film_id($r['user_id_from'],$r['film_id']);
                        $res['username'] = $row['username'];
                        $res['name'] = $row['name'];
                        $res['fb_id'] = $row['fb_id'];
                        $res['recommendation_id'] = $r['id'];
                    }
                    else
                    {
                        $res = FALSE;
                    }

                    
                    break;
                    */
                    
                }
               
                if(isset($res) && $res)
                {   
                     
                    $res->notif_type = $row->notif_type;
                    $res->object_type = $row->object_type;
                    $res->created_at = $row->created_at;
                    $res->seen = $row->seen;
                    $notifications_array[] = $res;
                }
                

            }
        }


        return $notifications_array;
    }


    public function clearNotifications($id)
    {
        
        if(Auth::user()->id === $id)
        {
            $data = array(
                'seen' => 1
                );
            return $this::where('to_user_id' , $id)->update( $data );
        }
        return false;
    }
}
     