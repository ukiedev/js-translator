<?php

namespace Webkid\JsTranslator;

use Illuminate\Support\Facades\Lang;
use Illuminate\Filesystem\Filesystem as File;

/**
 * Class JsTranslator
 *
 * @package Webkid\JsTranslator
 */
class JsTranslator
{
	/**
	 * @var array
	 */
	private $allLangFiles;

	/**
	 * @param string $langPath list of files in resource directory
	 * @param File $file
	 */
	public function __construct($langPath, File $file)
	{
		$this->allLangFiles = $file->allFiles($langPath);

		$fileKeys = [];

		foreach ($this->allLangFiles as $langFile) {
			$fileKeys[] = $langFile->getBasename('.php');
		}

		$this->fileKeys = $fileKeys;
	}

	/**
	 * Get array of translation according to locale
	 *
	 * @return array
	 */
	public function get()
	{
		$result = [];

		foreach ($this->fileKeys as $fileKey) {
			$result[$fileKey] = Lang::get($fileKey);
		}
		return $result;
	}

	/**
	 * Remove lang keys
	 * 
	 * @param array $keys
	 * @return $this
	 */
	public function except(array $keys)
	{
		$this->fileKeys = array_flip(array_except(array_flip($this->fileKeys), $keys));

		return $this;
	}

	/**
	 * Return only specific keys
	 * 
	 * @param array $keys
	 * @return $this
	 */
	public function only(array $keys)
	{
		$this->fileKeys = array_flip(array_only(array_flip($this->fileKeys), $keys));
		return $this;
	}
}
