<?php

namespace FileFinder;

use Illuminate\Support\Facades\File;

/**
 * FileFinder allows to find files and directories by content.
 */
class FileFinderHelper {
	const INTERNAL_ERROR = 500;
	const SUCCESS_STATUS = 200;

	public static $API_ERRORS = [
		1000 => 'Invalid search string!',
		1001 => 'Invalid case sensitive format!',
		1002 => 'Directory does not exist on this project!',
	];

	/**
	 * fileFilterAllowed variable
	 *
	 * @var array
	 */
	public $fileExtensionAllowed = ['txt'];

	/**
 * allowedFormat variable
 *
 * @var array
 */
	public $allowedFormat = ['on', 'off'];

	/**
	 * allowedStructureFormat variable
	 *
	 * @var array
	 */
	public $allowedStructureFormat = ['flatten', 'deep']; //TODO next version

	/**
	 * ignoredFolders variable
	 *
	 * @var array
	 */
	public $ignoredFolders = ['vendor', 'node_modules', 'bower_components'];

	/**
	 * searchedFilesCount variable
	 *
	 * @var array
	 */
	public $searchedFilesCount = 0;

	/**
	* Search files content
	*
	* @var $searchString string
	* @var $directory string
	* @var $sensitive string
	* @var $isJSON boolean
	* @return array
	**/
	public function searchByContent($searchString, $directory, $sensitive, $isJSON = true) {
		$foundFiles = [];
		$basePath = base_path();
		$directory = $directory !== '' ? $basePath . DIRECTORY_SEPARATOR . $directory : $basePath;

		if(is_null($searchString)) {
			return $this->apiErrors(1000);
		}

		if(!in_array($sensitive, $this->allowedFormat)) {
			return $this->apiErrors(1001);
		}

		if(!File::isDirectory($directory)) {
			return $this->apiErrors(1002);
		}

		$directories = File::directories($directory);
		$projectFiles = File::files($directory);
		$files = array_merge($directories, $projectFiles);

		foreach($files as $file) {
			if(File::isFile($file)) {
				$foundFiles = $this->checkFile($file, $foundFiles, $searchString, $sensitive);

				continue;
			}

			$directory = $this->extractDirectoryName($file);

			if(in_array($directory, $this->ignoredFolders)) {
				continue;
			}

			$folderFiles = File::allFiles($file);
			$foundFiles = $this->findFiles($searchString, $sensitive, $folderFiles, $foundFiles);
		}

		$data = [
			'searchedString' => $searchString,
			'searchedFilesCount' => $this->searchedFilesCount,
			'foundFilesCount' => count($foundFiles),
			'files' => $foundFiles
		];

		return $isJSON ? $this->jsonResponse($data, true) : $data;
	}

	private function findFiles($searchString, $sensitive, $files, $foundFiles) {
		foreach($files as $file) {
			$foundFiles = $this->checkFile($file, $foundFiles, $searchString, $sensitive);
		}

		return $foundFiles;
	}

	private function checkFile($file, $foundFiles, $searchString, $sensitive) {
		if(!in_array($file->getExtension(), $this->fileExtensionAllowed)) {
			return $foundFiles;
		}

		$this->searchedFilesCount++;
		$content = $this->formatString($sensitive, $file->getContents());
		$formatString = $this->formatString($sensitive, $searchString);
		$position = $searchString === '' ? 0 : strpos($content, $formatString);

		if($position !== false) {
			$foundFiles[] = $this->prepareFile($file, $position);
		}

		return $foundFiles;
	}

	/**
	* Prepare file array
	*
	 * @param $file object
	 * @param $position int
	 * @return array
	 */
	private function prepareFile($file, $position) {
		$directory = $this->extractDirectoryName($file->getRelativePath());

		return [
			'name' => $file->getFilename(),
			'directory' => $directory,
			'pathName' => $file->getRelativePath(),
			'extension' => $file->getExtension(),
			'size' => $file->getSize(),
			'positionString' => $position
		];
	}

	private function extractDirectoryName($path) {
		$split = explode(DIRECTORY_SEPARATOR, $path);

		return $split[count($split) - 1];
	}

	/**
	 * Check sensitive format about search content
	 * @param $sensitive string
	 * @param $string string
	 * @return string
	 */
	private function formatString($sensitive, $string) {
		return $sensitive === 'on' ? $string : strtolower($string);
	}

	private function apiErrors($code) {
		return $this->jsonResponse([
			'error' => self::$API_ERRORS[$code]
		], false);
	}

	public function jsonResponse($data, $isSuccess) {
		$status = $isSuccess ? self::SUCCESS_STATUS : self::INTERNAL_ERROR;

		return response()->json($data, $status);
	}

	public function getProjectDirectories() {
		$baseRootDirectories = File::directories(base_path());
		$directories = [
			'' => 'All directories'
		];

		foreach($baseRootDirectories as $directoryPath) {
			$directoryName = $this->extractDirectoryName($directoryPath);

			if(!in_array($directoryName, $this->ignoredFolders)) {
				$directories[$directoryName] = $directoryName;
			}
	}

		return $directories;
	}
}
