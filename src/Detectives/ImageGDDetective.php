<?php namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

class ImageGDDetective implements DetectiveContract
{
	use DetectiveTrait;

	/**
	 * Checks if thise file is a GIF.
	 *
	 * @return boolean|null
	 */
	protected function leadGIF()
	{
		$exif  = exif_imagetype($this->file) === IMAGETYPE_GIF;

		if ($exif)
		{
			return $this->closeCase("gif", "image/gif");
		}

		return null;
	}

	/**
	 * Checks if thise file is a JPG.
	 *
	 * @return boolean|null
	 */
	protected function leadJPG()
	{
		$exif   = exif_imagetype($this->file) === IMAGETYPE_JPEG;

		if ($exif)
		{
			return $this->closeCase("jpg", "image/jpg");
		}

		return null;
	}

	/**
	 * Checks if thise file is a PNG.
	 *
	 * @return boolean|null
	 */
	protected function leadPNG()
	{
		$exif  = exif_imagetype($this->file) === IMAGETYPE_PNG;

		if ($exif)
		{
			return $this->closeCase("png", "image/png");
		}

		return null;
	}

	/**
	 * Checks if the file is a SWF.
	 *
	 * @return boolean|null
	 */
	protected function leadSWF()
	{
		$exif  = exif_imagetype($this->file);
		$flash = ($exif === IMAGETYPE_SWF || $exif === IMAGETYPE_SWC);

		if ($exif)
		{
			return $this->closeCase("swf", "application/x-shockwave-flash");
		}

		return null;
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

		return false;
	}

	/**
	 * Can the system run this Detective?
	 *
	 * @return boolean  True if we can run, False if not.
	 */
	public static function on()
	{
		return function_exists("exif_imagetype");
	}
}
