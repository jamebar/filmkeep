<?php
  
class CustomList extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     
    protected $table = 'lists';
    protected $guarded = array();
     
    /*
     * A List belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /*
     * A List has many list films
     */
    public function listFilms()
    {
        return $this->hasMany('ListFilm', 'list_id');
    }

    
    public static function listsWithFilms($user, $num = 5)
    {

        $lists = array();

        foreach( $user->lists()->get() as $list )
        {
            $list_array = [];

            $list['films'] = ListFilm::select('f.*','list_films.id as list_film_id')
                    ->where('list_id', $list->id)
                    ->join('films as f', 'f.id', '=', 'list_films.film_id')
                    ->orderBy('list_films.sort_order', 'desc')
                    ->take($num)
                    ->get();
             
             $lists[] = $list;
        }

        return $lists;
    }


}