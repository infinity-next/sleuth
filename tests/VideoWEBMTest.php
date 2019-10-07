<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;
use \PHPUnit\Framework\TestCase;

class VideoWEBMTest extends TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.webm");
		$this->assertEquals('webm', $detective->getExtension());
	}
}
