<?php

class TheMovieDb {

	public $tmdb;
	
	public function __construct()
	{
		
		$apikey = 'f39589d9c877cecbe4032052979da1aa';
        	$this->tmdb = new TMDb($apikey,'en');
	}
    
	public function getFilmTrailer($tmdb_id)
	{
		
       
        	$trailer = $this->tmdb->getMovieTrailers($tmdb_id,'en');
		//$trailer = file_get_contents("http://api.themoviedb.org/3/movie/tt$imdb_id?api_key=f39589d9c877cecbe4032052979da1aa&append_to_response=trailers"); 
		//$trailer = json_decode($trailer);
        	return $trailer;
	}
	
	 /**
	 * Get film by tmdb id
	 * 
	 * Handles the Ajax call to search tmdb for films 
	 * 
	 */
	public function getFilmTmdb($tmdb_id)
	{

		$results = $this->tmdb->getMovie($tmdb_id, 'en');

		return $results;

	}
	
	public function getImgPath()
	{
		
		//get image path configuration
		if ( ! $image_path_config =  Cache::get("image_path_config"))
		{
			
			$image_path_config = $this->tmdb->getConfiguration();
		
			// Save into the cache for 1 week
			Cache::put('image_path_config', $image_path_config, 20160);
		}
		
		
		return $image_path_config;
	}

	/**
	* Film Search tmdb
	* 
	* Handles the Ajax call to search tmdb for films 
	* 
	*/
	public function searchTmdb($query)
	{

		return $this->tmdb->searchMovie($query, 1,'ngram');

	}
    
}