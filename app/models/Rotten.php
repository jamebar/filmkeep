<?php

class Rotten {

	protected $rotten;

	protected $apikey;

	protected $endpoint;
	
	public function __construct()
	{
		
		$this->apikey = 'gcu6mswmm3k7kevhmemu3uzd';
        	
        	$this->endpoint = "http://api.rottentomatoes.com/api/public/v1.0/movie_alias.json?apikey=".$this->apikey."&type=imdb&id=";
	}

	public static function getMovie($imdb_id)
	{
		if ( ! $rotten_info =  Cache::get("rotten-".$imdb_id))
		{

			$rotten = new Rotten;
			$session = curl_init($rotten->endpoint.$imdb_id);

			// indicates that we want the response back
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

			// exec curl and get the data back
			$data = curl_exec($session);

			// remember to close the curl session once we are finished retrieveing the data
			curl_close($session);

			// decode the json data to make it easier to parse the php
			$rotten_info = json_decode($data);
			if ($rotten_info === NULL) 
				return false;

			// Save into the cache for 1 month
			Cache::put("rotten-".$imdb_id, $rotten_info,  40320);
			
		}

		return $rotten_info;
	}
}

//http://api.rottentomatoes.com/api/public/v1.0/movie_alias.json?type=imdb&id=0499549&apikey=gcu6mswmm3k7kevhmemu3uzd