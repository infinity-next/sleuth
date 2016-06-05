<?php namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;
use enshrined\svgSanitize\Sanitizer;

class svgDetective implements DetectiveContract
{
	use DetectiveTrait;

	/**
	 * Checks if thise file is a valid SVG.
	 *
	 * @return boolean|null
	 */
	protected function leadSVG()
	{
		// Create a new sanitizer instance
		$sanitizer = new Sanitizer();

		// Load the dirty svg
		$dirtySVG = file_get_contents($this->file);

		// Pass it to the sanitizer and get it back clean
		$cleanSVG = $sanitizer->sanitize($dirtySVG);

		if (is_string($cleanSVG))
		{
			return $this->closeCase("svg", "image/svg+xml");
		}

		return false;
	}

	/**
	 * Can this file type potentially cause damage or intrude on a user's privacy?
	 * This means executable programs, or file formats that can contact remote servers in any way (even SVGs).
	 *
	 * @return boolean
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function isRisky()
	{
		parent::isRisky();

		return true;
	}

	/**
	 * Can the system run this Detective?
	 *
	 * @return boolean  True if we can run, False if not.
	 */
	public static function on()
	{
		return @class_exists(Sanitizer::class);
	}
}
