<?php namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

class ImageDetective implements DetectiveContract
{
	use DetectiveTrait;
	
	/**
	 * Checks if thise file is a GIF.
	 *
	 * @return boolean
	 */
	protected function leadGIF()
	{
		$exif  = exif_imagetype($this->file) === IMAGETYPE_GIF;
		
		if ($exif)
		{
			return $this->closeCase("gif", "image/gif");
		}
		
		return false;
	}
	
	/**
	 * Checks if thise file is a JPG.
	 *
	 * @return boolean
	 */
	protected function leadJPG()
	{
		$exif   = exif_imagetype($this->file) === IMAGETYPE_JPEG;
		
		if ($exif)
		{
			return $this->closeCase("jpg", "image/jpg");
		}
		
		return false;
	}
	
	/**
	 * Checks if thise file is a PNG.
	 *
	 * @return boolean
	 */
	protected function leadPNG()
	{
		$exif  = exif_imagetype($this->file) === IMAGETYPE_PNG;
		
		if ($exif)
		{
			return $this->closeCase("png", "image/png");
		}
		
		return false;
	}
	
	/**
	 * Can the system run this Detective?
	 *
	 * @return boolean  True if we can run, False if not.
	 */
	public function on()
	{
		return true;
	}
}