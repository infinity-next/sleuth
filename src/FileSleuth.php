<?php namespace InfinityNext\Sleuth;

use InfinityNext\Sleuth\Contracts\DetectiveContract;

class FileSleuth
{
	/**
	 * Detectives to be used to check the file.
	 *
	 * @var array
	 */
	protected $detectives = [
		'InfinityNext\Sleuth\Detectives\ImageGDDetective',
		'InfinityNext\Sleuth\Detectives\ffmpegDetective',
	];
	
	/**
	 * The file we're checking.
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * Instantiates the model.
	 *
	 * @param  $file  string  Optional parameter to automatically run a check.
	 * @return null|boolean
	 */
	public function __construct($file = null)
	{
		if (is_null($file))
		{
			return $this->check($file);
		}
	}
	
	/**
	 * Runs the file against all dectives.
	 *
	 * @param  $file  string  Optional parameter to automatically run a check.
	 * @return null|boolean
	 */
	public function check($file)
	{
		$case = null;
		
		foreach ($this->detectives as $detectiveClass)
		{
			$detective = new $detectiveClass();
			$case      = $detective->check($file);
			
			if ($case)
			{
				return $detective;
			}
		}
		
		return false;
	}
}
