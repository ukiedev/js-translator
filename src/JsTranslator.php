<?php

namespace Webkid\JsTranslator;

use Illuminate\Support\Facades\Lang;
use Illuminate\Filesystem\Filesystem as File;

class JsTranslator
{
	private $allLangFiles;

	/**
	 * Create a new Skeleton Instance
	 *
	 * @param      $langs
	 * @param File $file
	 */
	public function __construct($langs, File $file)
	{
		$this->allLangFiles = $file->allFiles($langs);
	}

	/**
	 * Get array of translation according to locale
	 *
	 * @return array
	 */
	public function get()
	{
		$result = [];

		foreach ($this->allLangFiles as $file) {
			$key = $file->getBasename('.php');

			$result[$key] = Lang::get($key);
		}
		return $result;
	}
}
