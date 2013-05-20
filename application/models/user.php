<?php

// A user has one club and has one restaurant
class User extends Eloquent 
{
	public function club()
	{
	    return $this->has_one('Club');
	}

	public function restaurant()
	{
	    return $this->has_one('Restaurant');
	}
}