<?php

use \InfinityNext\Sleuth\Detectives\ImageGDDetective as ImageDetective;
use \PHPUnit\Framework\TestCase;

class ImageWEBPTest extends TestCase
{
    public function testGood()
    {
        $detective = new ImageDetective;
        $detective->check(__DIR__ . "/files/normal.webp");
        $this->assertEquals('webp', $detective->getExtension());
    }

    public function testBad()
    {
        $detective = new ImageDetective;
        $detective->check(__DIR__ . "/files/normal.jpg");
        $this->assertNotEquals('png', $detective->getExtension());

        $detective = new ImageDetective;
        $detective->check(__DIR__ . "/files/png.jpg");
        $this->assertNotEquals('jpg', $detective->getExtension());
    }
}
