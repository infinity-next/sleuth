<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;
use \PHPUnit\Framework\TestCase;

class VideoMP4Test extends TestCase
{
	public function testMP4()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.mp4");
		$this->assertEquals('mp4', $detective->getExtension());
	}
}
