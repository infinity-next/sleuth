<?php

use \PHPUnit\Framework\TestCase;
use \InfinityNext\Sleuth\Detectives\ImagickDetective;
use \InfinityNext\Sleuth\Exceptions\CaseNotSolved;

class AppPDFTest extends TestCase
{
    public function testGoodVer13()
    {
        $detective = new ImagickDetective;
        $detective->check(__DIR__ . "/files/normal.pdf");
        $this->assertEquals('pdf', $detective->getExtension());
    }

    public function testGoodVer15()
    {
        $detective = new ImagickDetective;
        $detective->check(__DIR__ . "/files/normal2.pdf");
        $this->assertEquals('pdf', $detective->getExtension());
    }

    public function testBadImage()
    {
        $this->expectException(CaseNotSolved::class);
        $detective = new ImagickDetective;
        $detective->check(__DIR__ . "/files/normal.jpg");
        $this->assertNotEquals('pdf', $detective->getExtension());
    }

    public function testBadEpub()
    {
        $this->expectException(CaseNotSolved::class);
        $detective = new ImagickDetective;
        $detective->check(__DIR__ . "/files/png.jpg");
        $this->assertNotEquals('pdf', $detective->getExtension());
    }
}
