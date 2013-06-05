<?php

// A Club belongs_to user and has_many promotions
class Club extends Eloquent 
{
	public function user()
	{
	    return $this->belongs_to('User');
	}

	public function promotions()
	{
		return $this->has_many('Promotion');
	}
}