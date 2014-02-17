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

    protected $fillable = array('user_id','label','label_short');
    
    public $timestamps = false;
     
    /*
     * A Rating_type belongs to a Rating
     */
    public function ratings()
    {
        return $this->hasMany('Rating');
    }

    /*
     * A Rating_type belongs to a User
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /*
    * Returns all Rating Types including universal ones ( user_id = 0 ) and 
    * custom rating types by user_id
    * This is for the add and edit review forms.
    */
    public static function getRatingTypes($user_id = FALSE)
    {

        $rating_types =  RatingType::where('user_id', 0 );

        if($user_id)
        {
            $rating_types = $rating_types->orWhere('user_id',$user_id);
        }

        return $rating_types->get();
    }
      
    /*
    *   get custom rating types for a user
    *   
    */
    public static function getCustomTypes($user_id)
    {
        return User::find($user_id)->ratingTypes;
    }


    /*
    *   add custom rating types for a user
    *   
    */
    public static function addCustomType($user_id, $label)
    {   
        $label = strip_tags($label);

        $data = array(
            'user_id' => $user_id,
            'label' => ucfirst($label), 
            'label_short' => ucfirst($label)
            );

        return RatingType::create($data);
    }

    /*
    *   delete custom rating types for a user
    *   
    */
    public static function deleteCustomType($user_id, $id)
    {
        RatingType::where( 'id' , $id)->where('user_id', $user_id)->delete();
        return Rating::where( 'rating_type' , $id)->delete();
    }
}