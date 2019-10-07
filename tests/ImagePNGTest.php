<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as ImageDetective;
use \PHPUnit\Framework\TestCase;

class ImagePNGTest extends TestCase
{
	public function testGood()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$this->assertEquals('png', $detective->getExtension());

		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/png.jpg");
		$this->assertEquals('png', $detective->getExtension());
	}

	public function testBad()
	{
		$detective = new ImageDetective;
		$detective->check(__DIR__ . "/files/normal.gif");
		$this->assertNotEquals('png', $detective->getExtension());
	}
}
