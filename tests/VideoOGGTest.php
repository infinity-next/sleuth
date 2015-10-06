<?php

use \InfinityNext\Sleuth\Detectives\VideoDetective;

class VideoOGGTest extends PHPUnit_Framework_TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/ogv.ogv");
		$this->assertEquals('ogv', $detective->getExtension());
	}
	
	public function testBad()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/ogg.ogg");
		$this->assertEquals('ogv', $detective->getExtension());
	}
}
