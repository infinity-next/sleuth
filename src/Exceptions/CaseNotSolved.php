<?php namespace InfinityNext\Sleuth\Exceptions;

class CaseNotSolved extends \Exception
{
	/**
	 * Throw an exception for when trying to access a case's final details when it is not yet solved.
	 *
	 * @param  string|null  $message  The error message to throw.
	 * @param  integer  $code  Error code
	 * @param  \Exception  $previous  The previous error thrown.
	 * @return void
	 */
	public function __construct($message = null, $code = 0, \Exception $previous = null)
	{
		if (is_null($message))
		{
			$message = "Attempted to access details of a file in a Sleuth instance before the case was closed.";
		}
		
		parent::__construct($message, $code, $previous);
	}
}