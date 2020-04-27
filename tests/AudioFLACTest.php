<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as AudioDetective;
use \PHPUnit\Framework\TestCase;

class AudioFLACTest extends TestCase
{
    public function testOGG()
    {
        $detective = new AudioDetective;
        $detective->check(__DIR__ . "/files/normal.flac");
        $this->assertEquals('flac', $detective->getExtension());
    }
}
