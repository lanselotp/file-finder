<?php

namespace FileFinder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * FileFinder facade class
 */
class FileFinderFacade extends Facade
{
	/**
	 * getFacadeAccessor function
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'FileFinderFacade';
	}
}