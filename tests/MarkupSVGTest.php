<?php

use InfinityNext\Sleuth\Detectives\svgDetective as MarkupDetective;
use \PHPUnit\Framework\TestCase;

class MarkupSVGTest extends TestCase
{
	public function testGood()
	{
		$detective = new MarkupDetective;
		$detective->check(__DIR__ . "/files/normal.svg");
		$this->assertEquals('svg', $detective->getExtension());
	}

	/**
	 * @expectException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	*/
	public function testException()
	{
		$detective = new MarkupDetective;
		$detective->check(__DIR__ . "/files/normal.png");
		$detective->getExtension();
	}
}
