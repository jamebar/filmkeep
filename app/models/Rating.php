<?php
  
class Rating extends Eloquent {
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
    public $timestamps = false;

    /*
     * A Rating belongs to a Review
     */
    public function review()
    {
        return $this->belongsTo('Review', 'review_id');
    }
     
    /*
     * A Rating belongs to a Rating Type
     */
    public function ratingType()
    {
        return $this->belongsTo('RatingType');
    }
    
    
      
}