<?php

namespace FileFinder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use FileFinder\FileFinderHelper;

class FileFinderController extends Controller {
	public function index() {
		$fileFinder = new FileFinderHelper();
		$searchString = '';
		$sensitive = 'off';
		$directory = '';
		$data = $fileFinder->searchByContent($searchString, $directory, $sensitive, false);
		$directories = $fileFinder->getProjectDirectories();

		return view('fileFinder::index', compact('data', 'directories'));
	}

	public function getFilesByContent() {
		$fileFinder = new FileFinderHelper();
		$searchString = Input::get('searchString', null);
		$directory = Input::get('directory', '');
		$sensitive = Input::get('sensitive', '');

		return $fileFinder->searchByContent($searchString, $directory, $sensitive, true);
	}
}