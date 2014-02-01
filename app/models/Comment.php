<?php
  
class Comment extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    // protected $table = 'dates';
    protected $fillable = array('user_id', 'object_id', 'object_type', 'comment', 'spoiler');
    
     
    /*
     * A Comment belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    
      
    public static function getComments($object_id, $type, $num = 0)
    {
        $comments = DB::table('comments as com')
                    ->select('com.*', 'u.username as username', 'u.name as name', 'u.profile_pic as profile_pic')
                    ->where("com.object_id","$object_id")
                    ->where("com.object_type", $type)
                    ->join('users as u', 'u.id',  '=',  'com.user_id');
                    
        
        if($num>0){
            $comments = $comments->limit($num); 
            $comments = $comments->orderBy('com.created_at','desc');
            $comments = $comments->get();
            return array_reverse($comments);

        }else
        {
            $comments = $comments->orderBy('com.created_at','asc');
            $comments = $comments->get();
            return $comments;
        }


    }
 

    public static function addComment($user_id, $object_id, $object_type, $comment, $spoiler)
    {
        $comment = Comment::create(array(
                    'user_id' => $user_id,
                    'object_id' => $object_id,
                    'object_type' => $object_type,
                    'comment' => $comment,
                    'spoiler' => $spoiler
                ));

        if($comment)
        {
            $c_id = $comment->id;
            //Add notification

            //find owner of object
            $owner_ids = array();
            $owners = array();
            $owner = DB::table($object_type)
                        ->where('id' , $object_id )
                        ->first();

            if($object_type == 'recommendations')
            {
                $owner_ids[] = $owner->user_id_to;
                $owner_ids[] = $owner->user_id_from;
                $owners[] = array('user_id'=>$owner->user_id_to);
                $owners[] = array('user_id'=>$owner->user_id_from);
            }
            else
            {
                $owner_ids[] = $owner->user_id;
                $owners[] = (object)array('user_id' => $owner->user_id );
            }

            //first find all users who have commented in this thread.
            $users = DB::table('comments')
                            ->select('user_id')
                            ->groupBy('user_id')
                            ->where('object_type', $object_type )
                            ->where('object_id' , $object_id )
                            ->whereNotIn('user_id', $owner_ids )
                            ->get();

            
            $users = array_merge($users , $owners);

            foreach($users as $user)
            {
                //check to make sure the commenter is not getting a notification
                if($user_id !== $user->user_id)
                {
                    $notif_data = array(

                        'from_user_id' => $user_id,
                        'to_user_id' => $user->user_id,
                        'object_type' => $object_type,
                        'notif_type' => 'comments',
                        'object_id' =>  $object_id

                    );

                    Notification::addNotification($notif_data);
                }
                
            }

            return $c_id;
        }
        else
        {
            return 'false';
        }
        
    }

    public function deleteComment($id)
    {
        return $this::where( 'id' , $id)->delete();
        
    }
    
}
