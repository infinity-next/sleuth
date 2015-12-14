<?php namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

class ffmpegDetective implements DetectiveContract
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
			$cmd   = env('LIB_FFPROBE', "ffprobe") . " -v quiet -print_format json -show_format -show_streams {$this->file}";
			
			exec($cmd, $output, $returnvalue);
			
			$json = json_decode( implode("\n", $output), true );
			
			if (!is_array($json))
			{
				$json = false;
			}
			
			$this->metadata = $json;
			
			if ($this->ffprobeHasFormat())
			{
				$this->formats = array_filter(explode(",", $json['format']['format_name']));
			}
		}
	}
	
	/**
	 * Checks requested format against what formats ffprobe returned.
	 *
	 * @param  string  $format  The format extenson to check for.
	 * @param  string|null  $format  Option number of additional formats.
	 * @return boolean|null
	 */
	private function ffprobeFormat($format)
	{
		$this->ffprobe();
		
		if (count($this->formats) > 0)
		{
			$args = func_get_args();
			
			foreach ($args as $arg)
			{
				if (in_array($arg, $this->formats))
				{
					return true;
				}
			}
			
			return null;
		}
		
		return false;
	}
	
	/**
	 * Check our metadata for format name.
	 *
	 * @return boolean|string  String if format found, false if none.
	 */
	private function ffprobeHasFormat()
	{
		if (isset($this->metadata['format']['format_name']))
		{
			return $this->metadata['format']['format_name'] ?: false;
		}
		
		return false;
	}
	
	/**
	 * Check our metadata for a video stream.
	 *
	 * @return boolean|int  Int if video stream index found (CAN BE 0), false if none
	 */
	private function ffprobeHasVideo()
	{
		if (isset($this->metadata['streams']))
		{
			foreach ($this->metadata['streams'] as $streamIndex => $stream)
			{
				if (isset($stream['codec_type']) && $stream['codec_type'] === "video" && $stream['disposition']['attached_pic'] !== 1)
				{
					return $streamIndex;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Check our metadata for an audio stream.
	 *
	 * @return boolean|int  Int if video stream index found (CAN BE 0), false if none
	 */
	private function ffprobeHasAudio()
	{
		if (isset($this->metadata['streams']))
		{
			foreach ($this->metadata['streams'] as $streamIndex => $stream)
			{
				if (isset($stream['codec_type']) && $stream['codec_type'] === "audio")
				{
					return $streamIndex;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Checks if the file is a 3GP.
	 *
	 * @return boolean|null
	 */
	protected function lead3GP()
	{
		$lead = $this->ffprobeFormat("3gp");
		
		if ($lead === true)
		{
			return $this->closeCase("3gp", "video/3gp", $this->metadata);
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a AAC
	 *
	 * @return boolean|null
	 */
	protected function leadAAC()
	{
		$lead = $this->ffprobeFormat("aac");
		
		if ($lead === true)
		{
			return $this->closeCase("aac", "audio/aac", $this->metadata);
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a FLV.
	 *
	 * @return boolean|null
	 */
	protected function leadFLV()
	{
		$lead = $this->ffprobeFormat("flv");
		
		if ($lead === true)
		{
			return $this->closeCase("flv", "video/x-flv", $this->metadata);
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a MP3
	 *
	 * @return boolean|null
	 */
	protected function leadMP3()
	{
		$lead = $this->ffprobeFormat("mp1", "mp2", "mp3", "mpg", "mpeg");
		
		if ($lead === true)
		{
			return $this->closeCase("mp3", "audio/mpeg", $this->metadata);
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a MP4.
	 *
	 * @return boolean|null
	 */
	protected function leadMP4()
	{
		$lead = $this->ffprobeFormat("mp4", "m4a");
		
		if ($lead === true)
		{
			if ($this->ffprobeHasVideo() !== false)
			{
				return $this->closeCase("mp4", "video/mp4", $this->metadata);
			}
			else if ($this->ffprobeHasAudio() !== false)
			{
				return $this->closeCase("mp4", "audio/mp4", $this->metadata);
			}
			else
			{
				return false;
			}
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a MKA.
	 *
	 * @return boolean|null
	 */
	protected function leadMKA()
	{
		$lead = $this->ffprobeFormat("matroska", "webm");
		
		if ($lead === true)
		{
			if ($this->ffprobeHasAudio() !== false)
			{
				return $this->closeCase("mka", "audio/x-matroska", $this->metadata);
			}
			else
			{
				return false;
			}
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a MKV.
	 *
	 * @return boolean|null
	 */
	protected function leadMKV()
	{
		$lead = $this->ffprobeFormat("matroska", "webm");
		
		if ($lead === true)
		{
			if ($this->ffprobeHasVideo() !== false)
			{
				return $this->closeCase("mkv", "video/x-matroska", $this->metadata);
			}
			else
			{
				return false;
			}
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a OGG Audio-only (OGA).
	 *
	 * @return boolean|null
	 */
	protected function leadOGG()
	{
		$lead  = $this->ffprobeFormat("ogg", "oga", "ogv");
		
		if ($lead === true)
		{
			if ($this->ffprobeHasVideo() !== false)
			{
				return $this->closeCase("ogg", "video/ogg", $this->metadata);
			}
			else if ($this->ffprobeHasAudio() !== false)
			{
				return $this->closeCase("ogg", "audio/ogg", $this->metadata);
			}
			else
			{
				return false;
			}
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a WAV
	 *
	 * @return boolean|null
	 */
	protected function leadWAV()
	{
		$lead = $this->ffprobeFormat("wav");
		
		if ($lead === true)
		{
			return $this->closeCase("wav", "audio/wave", $this->metadata);
		}
		
		return null;
	}
	
	/**
	 * Checks if the file is a WEBM.
	 *
	 * @return boolean|null
	 */
	protected function leadWEBM()
	{
		$lead = $this->ffprobeFormat("webm");
		
		if ($lead === true)
		{
			if ($this->ffprobeHasVideo() !== false)
			{
				return $this->closeCase("webm", "video/webm", $this->metadata);
			}
			else if ($this->ffprobeHasAudio() !== false)
			{
				return $this->closeCase("webm", "audio/webm", $this->metadata);
			}
			else
			{
				return false;
			}
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
	public function on()
	{
		$ffmpeg  = shell_exec("which ffmpeg");
		$ffprobe = shell_exec("which ffprobe");
		
		return (empty($ffmpeg) ? false : true) && (empty($ffprobe) ? false : true);
	}
}