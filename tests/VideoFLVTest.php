<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;

class VideoFLVTest extends PHPUnit_Framework_TestCase
{
	public function testFLV()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.flv");
		$this->assertEquals('flv', $detective->getExtension());
	}
}
