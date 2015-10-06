<?php namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

class VideoDetective implements DetectiveContract
{
	use DetectiveTrait;
	
	/**
	 * Format types detected by ffprobe.
	 *
	 * @var array
	 */
	private $formats;
	
	/**
	 * Runs an ffprobe on the file or returns cached information.
	 *
	 * @return array|false
	 */
	private function ffprobe()
	{
		if (!isset($this->metadata))
		{
			$cmd   = "ffprobe -v error -print_format json -show_format -show_streams {$this->file}";
			
			exec($cmd, $output, $returnvalue);
			
			$json = json_decode( implode("\n", $output), true );
			
			if (!is_array($json))
			{
				$json = false;
			}
			
			$this->metadata = $json;
			
			if ($json['streams'][0]['codec_type'] === "video" && isset($json['format']['format_name']))
			{
				$this->formats = array_filter(explode(",", $json['format']['format_name']));;
			}
		}
	}
	
	/**
	 * Checks requested format against what formats ffprobe returned.
	 *
	 * @return boolean|null
	 */
	private function ffprobeFormat($format)
	{
		$this->ffprobe();
		
		if (count($this->formats) > 0)
		{
			if (in_array($format, $this->formats))
			{
				var_dump("Found it! :)");
				return true;
			}
			
			return null;
		}
		
		return false;
	}
	
	/**
	 * Checks if the file is a WEBM.
	 *
	 * @return boolean
	 */
	protected function lead3GP()
	{
		$lead = $this->ffprobeFormat("3gp");
		
		if ($lead === true)
		{
			return $this->closeCase("3gp", "video/3gp", $this->metadata);
		}
		
		return true;
	}
	
	/**
	 * Checks if the file is a WEBM.
	 *
	 * @return boolean
	 */
	protected function leadMP4()
	{
		$lead = $this->ffprobeFormat("mp4");
		
		if ($lead === true)
		{
			return $this->closeCase("mp4", "video/mp4", $this->metadata);
		}
		
		return true;
	}
	
	/**
	 * Checks if the file is a WEBM.
	 *
	 * @return boolean
	 */
	protected function leadFLV()
	{
		$lead = $this->ffprobeFormat("flv");
		
		if ($lead === true)
		{
			return $this->closeCase("flv", "video/x-flv", $this->metadata);
		}
		
		return true;
	}
	
	/**
	 * Checks if the file is a WEBM.
	 *
	 * @return boolean
	 */
	protected function leadWEBM()
	{
		$lead = $this->ffprobeFormat("webm");
		
		if ($lead === true)
		{
			return $this->closeCase("webm", "video/webm", $this->metadata);
		}
		
		return true;
	}
	
	/**
	 * Can the system run this Detective?
	 *
	 * @return boolean  True if we can run, False if not.
	 */
	public function on()
	{
		$ffmpeg  = shell_exec("which ffmpeg");
		$ffprobe = shell_exec("which ffprobe");
		
		return (empty($ffmpeg) ? false : true) && (empty($ffprobe) ? false : true);
	}
}