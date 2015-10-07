<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as FlashDetective;

class AppSWFTest extends PHPUnit_Framework_TestCase
{
	public function testSWF()
	{
		$detective = new FlashDetective;
		$detective->check(__DIR__ . "/files/normal.swf");
		$this->assertEquals('swf', $detective->getExtension());
	}
}
