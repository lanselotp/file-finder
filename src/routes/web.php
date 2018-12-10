<?php
	Route::group([
		'namespace' => 'FileFinder\Http\Controllers'
	], function() {
		Route::get('/file-finder-demo', 'FileFinderController@index');
		Route::get('/file-finder/api/searchByContent', 'FileFinderController@getFilesByContent');
	});