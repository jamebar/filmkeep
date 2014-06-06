<?php
  
class Invite extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     

    protected $guarded = array();
     
    /*
     * An invite belongs to a user
     */
    public function referrer()
    {
        return $this->belongsTo('User', 'referrer_user_id');
    }

    

}