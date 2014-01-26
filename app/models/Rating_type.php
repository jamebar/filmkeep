<?php
  
class Rating_type extends Eloquent {
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
    
      
}