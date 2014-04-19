<?php
  
class recommendation extends Eloquent {
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
     * An Event belongs to a film
     */
    public function film()
    {
        return $this->belongsTo('Film');
    }
     
    public static function addRecommendation($data)
    {
        
        
        $rec = Recommendation::create( $data );
        

        //add the event
        $event_data = array(
            'user_id' => $data['user_id_from'],
            'related_id' => $rec->id,
            'type' => 'recommendations',
        );
        
        Activity::create($event_data);

        //add Notification
        $notif_data = array(

            'from_user_id' => $data['user_id_from'],
            'to_user_id' => $data['user_id_to'],
            'object_type' => 'recommendations',
            'notif_type' => 'recommendations',
            'object_id' =>  $rec->id

        );
        Notification::create( $notif_data );

        return $rec->id;
    }
    
      
}