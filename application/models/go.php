<?php

// A user has one club and has one restaurant
class Go extends Eloquent 
{
	public function user()
	{
	    return $this->belongs_to('User');
	}
}