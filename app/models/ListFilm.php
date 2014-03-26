<?php
  
class ListFilm extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'list_films';
    protected $guarded = array();
     
    

    /*
     * A List_film has many films
     */
    public function films()
    {
        return $this->hasMany('Film');
    }

    /*
     * A List_film belongs to a list
     */
    public function customList()
    {
        return $this->belongsTo('CustomList');
    }
    


}