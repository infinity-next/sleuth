<?php namespace \InfinityNext\Sleuth\Facades;

use Illuminate\Support\Facades\Facade;

class Sleuth extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return 'sleuth';
	}
	
}
