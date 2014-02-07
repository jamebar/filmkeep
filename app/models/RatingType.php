<?php
  
class RatingType extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'rating_type';
     
    
     
    /*
     * A Rating_type belongs to a Rating
     */
    public function rating()
    {
        return $this->belongsTo('Rating');
    }
    
    public static function getRatingTypes($user_id = FALSE)
    {

        $rating_types =  RatingType::where('user_id', 0 );
        
        if($user_id)
        {
            $rating_types = $rating_types->orWhere('user_id',$user_id);
        }

        return $rating_types->get();
    }
      
}