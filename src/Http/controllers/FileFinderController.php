<?php

namespace FileFinder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use FileFinder\FileFinderHelper;

class FileFinderController extends Controller {
	public function index() {
		$fileFinder = new FileFinderHelper();
		$string = '';
		$sensitive = 'off';
		$directory = '';
		$data = $fileFinder->searchByContent(false, $string, $directory, $sensitive);
		$directories = $fileFinder->getProjectDirectories();

		return view('fileFinder::index', compact('data', 'directories'));
	}

	public function searchByContent() {
		$fileFinder = new FileFinderHelper();
		$string = Input::get('searchKey', null);
		$directory = Input::get('directory', base_path());
		$sensitive = Input::get('sensitive', 'off');

		return $fileFinder->searchByContent(true, $string, $directory, $sensitive);
	}
}