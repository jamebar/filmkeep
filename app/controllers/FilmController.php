<?php

class FilmController extends BaseController
{    

	public function film($film_id)
	{	
		$film = new Film();
		$data['film'] = $film->getFilm($film_id);

		if(Auth::check())
		{
			$data['watchlist'] = Watchlist::getWatchlist(Auth::user()->id);
		}
		
		$data['page_title'] = $data['film']['title'];
		

		$imdb_id = $data['film']['imdb_id'];

		if(strpos($imdb_id , 'tt') !== false)
		{
			$imdb_id = explode('tt', $data['film']['imdb_id'])[1];
		}
		
		$data['rotten'] = Rotten::getMovie( $imdb_id );

		$tmdb = new TheMovieDb();
		$data['tmdb_info'] = $tmdb->getFilmTmdb($data['film']['tmdb_id']);

		return View::make('film', $data);

	}
}