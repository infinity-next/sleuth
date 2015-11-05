<?php

use InfinityNext\Sleuth\Detectives\svgDetective as MarkupDetective;

class MarkupSVGTest extends PHPUnit_Framework_TestCase
{
	public function testGood()
	{
		$detective = new MarkupDetective;
		$detective->check(__DIR__ . "/files/normal.svg");
		$this->assertEquals('svg', $detective->getExtension());
	}
	
	/**
	 * @expectedException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	*/
	public function testException()
	{
		$detective = new MarkupDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$detective->getExtension();
	}
}