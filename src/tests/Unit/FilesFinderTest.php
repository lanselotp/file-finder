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

		$data = $fileFinder->searchByContent(false, $string);
		$isTrue = true;

		if(!is_array($data)) {
			$isTrue = false;
		}
		else {
			if(!isset($data['searchedFiles']) || !is_int($data['searchedFiles'])) {
				$isTrue = false;
			}
			if(!isset($data['foundFiles']) || !is_int($data['foundFiles'])) {
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
		$string = null;
		$responseSearchedKey = $this->get('/api/searchByContent?searchKey=');
		$responseSensitive = $this->get('/api/searchByContent?searchKey=test&sensitive=not_valid');

		$responseSearchedKey->assertExactJson([
			'error' => FileFinderHelper::$API_ERRORS[1000],
		]);
		$responseSensitive->assertExactJson([
			'error' => FileFinderHelper::$API_ERRORS[1001],
		]);
	}
}