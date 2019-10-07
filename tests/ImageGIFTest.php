<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as ImageDetective;
use \PHPUnit\Framework\TestCase;

class ImageGIFTest extends TestCase
{
	public function testGood()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.gif");
		$this->assertEquals('gif', $detective->getExtension());

		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/animated.gif");
		$this->assertEquals('gif', $detective->getExtension());
	}

	public function testBad()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$this->assertNotEquals('gif', $detective->getExtension());
	}

	/**
	 * @expectException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	*/
	public function testException()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.pdf");
		$detective->getExtension();
	}
}
