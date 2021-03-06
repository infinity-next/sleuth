<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as ImageDetective;
use \PHPUnit\Framework\TestCase;

class ImageJPGTest extends TestCase
{
	public function testGood()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.jpg");
		$this->assertEquals('jpg', $detective->getExtension());
	}

	public function testBad()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$this->assertNotEquals('jpg', $detective->getExtension());

		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/png.jpg");
		$this->assertNotEquals('jpg', $detective->getExtension());
	}
}
