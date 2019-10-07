<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as VideoDetective;
use \PHPUnit\Framework\TestCase;

class Video3GPTest extends TestCase
{
	public function test3GP()
	{
		$detective = new VideoDetective;
		$detective->check(__DIR__ . "/files/normal.3gp");
		$this->assertEquals('3gp', $detective->getExtension());
	}
}
