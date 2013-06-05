<?php

// A user has many nimkus and has many and belongs to followers
class Restaurant extends Eloquent 
{
	public function user()
	{
	    return $this->belongs_to('User');
	}
}