<?php namespace InfinityNext\Sleuth;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Detectives\ImageGDDetective;
use InfinityNext\Sleuth\Detectives\ffmpegDetective;
use InfinityNext\Sleuth\Detectives\svgDetective;

class FileSleuth
{
	/**
	 * Detectives to be used to check the file.
	 *
	 * @var array
	 */
	protected $detectives = [
		ImageGDDetective::class,
		ffmpegDetective::class,
		svgDetective::class,
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
	 * @param  string  $file  Optional parameter to automatically run a check.
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
	 * @param  string  $file  Optional parameter to automatically run a check.
	 * @param  string|null  $verify  Extension to verify against. Checks all possible if unset.
	 * @return null|boolean
	 */
	public function check($file, $verify = null)
	{
		if (is_string($verify))
		{
			$verify = "lead" . strtoupper($verify);
		}

		$detectives = [];
		foreach ($this->detectives as $detectiveClass)
		{
			if ($detectiveClass::on())
			{
				$detectives[] = $detectiveClass;
			}
		}

		$case = null;

		foreach ($detectives as $detectiveClass)
		{
			$detective = new $detectiveClass();
			$case      = $detective->check($file, $verify);

			if ($case)
			{
				return $detective;
			}
		}

		return false;
	}
}
