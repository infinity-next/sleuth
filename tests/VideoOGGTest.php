<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;

class VideoOGGTest extends PHPUnit_Framework_TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.ogv");
		$this->assertEquals('ogg', $detective->getExtension());
	}
}
