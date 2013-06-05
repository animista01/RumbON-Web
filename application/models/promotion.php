<?php

// Una promocion pertenece a un Club y un club puede tener muchas promociones
class Promotion extends Eloquent 
{
	public function club()
	{
	    return $this->belongs_to('Club');
	}
}