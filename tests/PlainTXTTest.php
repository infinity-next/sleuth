<?php

use InfinityNext\Sleuth\Detectives\PlaintextDetective;
use InfinityNext\Sleuth\Exceptions\CaseNotSolved;
use PHPUnit\Framework\TestCase;

class PlainTXTtest extends TestCase
{
    ## TODO: Add actual .txt verification.
    public function testNotPgp()
    {
        $this->expectException(CaseNotSolved::class);
        $detective = new PlaintextDetective;
        $detective->check(__DIR__ . "/files/normal.txt"); // use clearsign because it contains nested identifiers
        $this->assertNotEquals('asc', $detective->getExtension());
        //$this->asserFalse($detective->isPgp());
        //$this->assertNotEquals(PlaintextDetective::PGP_INVALID, $detective->getPgpType());
    }

}
