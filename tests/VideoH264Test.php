<?php

use \InfinityNext\Sleuth\Detectives\VideoDetective;

class VideoH264Test extends PHPUnit_Framework_TestCase
{
	public function test3GP()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/3gp.3gp");
		$this->assertEquals('3gp', $detective->getExtension());
	}
	
	public function testMP4()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/mp4.mp4");
		$this->assertEquals('mp4', $detective->getExtension());
	}
	
	public function testFLV()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/flv.flv");
		$this->assertEquals('flv', $detective->getExtension());
	}
}
