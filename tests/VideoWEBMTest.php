<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;

class VideoWEBMTest extends PHPUnit_Framework_TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.webm");
		$this->assertEquals('webm', $detective->getExtension());
	}
}
