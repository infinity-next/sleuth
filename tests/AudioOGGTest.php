<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as AudioDetective;
use \PHPUnit\Framework\TestCase;

class AudioOGGTest extends TestCase
{
	public function testOGG()
	{
		$detective = new AudioDetective;
		$detective->check(__DIR__ . "/files/normal.ogg");
		$this->assertEquals('ogg', $detective->getExtension());
	}
}
