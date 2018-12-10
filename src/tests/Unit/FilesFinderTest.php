<?php

use FileFinder\FileFinderHelper;
use Tests\TestCase;

/**
 * FileFinderTest class
 */
class FileFinderTest extends TestCase {
	/**
	 * Positive test for function `searchByContent`
	 *
	 * @return void
	 */
	public function testSearchByContentData() {
		$fileFinder = new FileFinderHelper();
		$string = 'Test content for unit tests';
		$directory = 'public';
		$sensitive = 'off';

		$data = $fileFinder->searchByContent($string, $directory, $sensitive, false);
		$isTrue = true;

			if(!is_array($data)) {
			$isTrue = false;
		}
		else {
			if(!isset($data['searchedFilesCount']) || !is_int($data['searchedFilesCount'])) {
				$isTrue = false;
			}
			if(!isset($data['foundFilesCount']) || !is_int($data['foundFilesCount'])) {
				$isTrue = false;
			}
			if(!isset($data['searchedString']) || !is_string($data['searchedString'])) {
				$isTrue = false;
			}
			if(!isset($data['files']) || !is_array($data['files'])) {
				$isTrue = false;
			}
		}

		$this->assertTrue($isTrue);
	}

	/**
	 * Positive test for function `searchByContent`
	 *
	 * @return void
	 */
	public function testErrorsApiInvalidParams() {
		$apiRoute = '/file-finder/api/searchByContent';

		$responseSearchedKey = $this->get($apiRoute);
		$responseSensitive = $this->get($apiRoute . '?searchString=test&sensitive=not_valid');
		$responseDirectory = $this->get($apiRoute . '?searchString=test&directory=not_valid&sensitive=off');

		$responseSearchedKey->assertExactJson([
			'error' => FileFinderHelper::$API_ERRORS[1000],
		]);
		$responseSensitive->assertExactJson([
			'error' => FileFinderHelper::$API_ERRORS[1001],
		]);
		$responseDirectory->assertExactJson([
			'error' => FileFinderHelper::$API_ERRORS[1002],
		]);
	}
}