<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class FileFinderDemoTest extends DuskTestCase {
	private $fileFinderDemoRoute = '/file-finder-demo';
		/**
		 * Check is form elements are presented.
		 *
		 * @return void
		 */
		public function testSeeFileFinderDemoElements() {
			$this->browse(function (Browser $browser) {
					$browser
						->visit($this->fileFinderDemoRoute)
					 ->assertPresent('@sensitive-select')
					 ->assertPresent('@directories-select')
					 ->assertPresent('@file-finder-input')
					 ->assertEnabled('@file-finder-input')
					 ->assertPresent('@file-finder-search-button')
					 ->assertPresent('@file-finder-documentation-show')
					 ->assertPresent('@file-finder-documentation-hide');
			});
		}

	public function testFormDemoNotResultsFound() {
		$this->browse(function (Browser $browser) {
			$browser
				->visit($this->fileFinderDemoRoute)
				->type('@file-finder-input', 'invalid_file_content_content')
				->click('@file-finder-search-button')
				->assertSee('No files content matched your search criteria !');
		});
	}

	public function testFormDemoResultsFound() {
		$this->browse(function (Browser $browser) {
			$browser
				->visit($this->fileFinderDemoRoute)
				->type('@file-finder-input', 'test')
				->click('@file-finder-search-button')
				->assertPresent('.files');
		});
	}

	public function testFileFinderDocumentationAnimation() {
		$this->browse(function (Browser $browser) {
			$browser
				->visit($this->fileFinderDemoRoute)
				->click('@file-finder-documentation-show')
				->assertPresent('.show-documentation')
				->click('@file-finder-documentation-hide')
				->assertMissing('.show-documentation');
		});
	}
}
