<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;
use \PHPUnit\Framework\TestCase;

class VideoOGGTest extends TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.ogv");
		$this->assertEquals('ogg', $detective->getExtension());
	}
}
