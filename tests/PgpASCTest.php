<?php

use InfinityNext\Sleuth\Detectives\PlaintextDetective;
use PHPUnit\Framework\TestCase;

class PgpASCTest extends TestCase
{
    public function testClearsign()
    {
        $detective = new PlaintextDetective;
        $detective->check(__DIR__ . "/files/clearsign.asc");
        $this->assertEquals('asc', $detective->getExtension());
        $this->assertTrue($detective->isPgp());
        $this->assertEquals(PlaintextDetective::PGP_CLEARSIGN, $detective->getPgpType());
    }

    public function testPubkey()
    {
        $detective = new PlaintextDetective;
        $detective->check(__DIR__ . "/files/pubkey.asc");
        $this->assertEquals('asc', $detective->getExtension());
        $this->assertTrue($detective->isPgp());
        $this->assertEquals(PlaintextDetective::PGP_PUBKEY, $detective->getPgpType());
    }

    public function testSignature()
    {
        $detective = new PlaintextDetective;
        $detective->check(__DIR__ . "/files/detached.asc");
        $this->assertEquals('asc', $detective->getExtension());
        $this->assertTrue($detective->isPgp());
        $this->assertEquals(PlaintextDetective::PGP_SIGNATURE, $detective->getPgpType());
    }

    public function testNoMismatch()
    {
        $detective = new PlaintextDetective;
        $detective->check(__DIR__ . "/files/clearsign.asc"); // use clearsign because it contains nested identifiers
        $this->assertEquals('asc', $detective->getExtension());
        $this->assertTrue($detective->isPgp());
        $this->assertNotEquals(PlaintextDetective::PGP_INVALID, $detective->getPgpType());
        $this->assertNotEquals(PlaintextDetective::PGP_PUBKEY, $detective->getPgpType());
        $this->assertNotEquals(PlaintextDetective::PGP_SIGNATURE, $detective->getPgpType());
    }
}
