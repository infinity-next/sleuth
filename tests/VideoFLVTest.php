<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;
use \PHPUnit\Framework\TestCase;

class VideoFLVTest extends TestCase
{
	public function testFLV()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.flv");
		$this->assertEquals('flv', $detective->getExtension());
	}
}
