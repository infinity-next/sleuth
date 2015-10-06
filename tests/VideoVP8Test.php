<?php

use \InfinityNext\Sleuth\Detectives\ImageDetective;
use \InfinityNext\Sleuth\Detectives\VideoDetective;

class VideoVP8Test extends PHPUnit_Framework_TestCase
{
	public function testGood()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/webm.webm");
		$this->assertEquals('webm', $detective->getExtension());
	}
	
	/**
	 * @expectedException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	*/
	public function testImageToVideoException()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$detective->getExtension();
	}
	
	/**
	 * @expectedException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	*/
	public function textVideoToImageException()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/webm.webm");
		$detective->getExtension();
	}
}
