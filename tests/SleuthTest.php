<?php

use InfinityNext\Sleuth\FileSleuth;
use \PHPUnit\Framework\TestCase;

class SleuthTest extends TestCase
{
	public function testSleuth()
	{
		$files = [
			'jpg' => __DIR__ . "/files/normal.jpg",
			'mp4' => __DIR__ . "/files/normal.mp4",
			'svg' => __DIR__ . "/files/normal.svg",
		];

		foreach ($files as $ext => $file)
		{
			$sleuth = new FileSleuth($file);
			$case   = $sleuth->check($file);

			$this->assertEquals($ext, $case->getExtension());
		}
	}
}
