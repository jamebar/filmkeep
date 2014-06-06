<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $guarded = array('id', 'email');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/*
	* A user has many reviews
	*/
	public function reviews()
	{
	return $this->hasMany('Review');
	}

	/*
	* A user has many watchlist
	*/
	public function watchlist()
	{
	return $this->hasMany('Watchlist');
	}

	/*
	* A user has many rating types
	*/
	public function ratingTypes()
	{
	return $this->hasMany('RatingType');
	}

	/*
	* A user has many invites
	*/
	public function invites()
	{
	return $this->hasMany('Invite', 'referrer_user_id');
	}

	/*
	* A user has many lists
	*/
	public function lists()
	{
	return $this->hasMany('CustomList');
	}

	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

}