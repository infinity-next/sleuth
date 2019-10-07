<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as FlashDetective;
use \PHPUnit\Framework\TestCase;

class AppSWFTest extends TestCase
{
	public function testSWF()
	{
		$detective = new FlashDetective;
		$detective->check(__DIR__ . "/files/normal.swf");
		$this->assertEquals('swf', $detective->getExtension());
	}
}
