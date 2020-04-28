<?php

namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

/**
 * Handles files which are plain text but which may conform to container standards.
 */
class PlaintextDetective implements DetectiveContract
{
    use DetectiveTrait;

    protected $pgpType = null;

    const PGP_INVALID = 0;
    const PGP_PUBKEY = 1;
    const PGP_SIGNATURE = 2;
    const PGP_CLEARSIGN = 3;

    /**
     * Checks if thise file is an 'Armored ASCII' PGP file.
     *
     * @return boolean|null
     */
    protected function leadASC()
    {
        $contents = trim($this->getFileContents());

        if (mb_ereg_match("^-+BEGIN PGP PUBLIC KEY BLOCK-+.*-+END PGP PUBLIC KEY BLOCK-+$", $contents)) {
            $this->pgpType = static::PGP_PUBKEY;
            return $this->closeCase("asc", "text/plain");
        }
        elseif (mb_ereg_match("^-+BEGIN PGP SIGNED MESSAGE-+.*-+BEGIN PGP SIGNATURE-+.*-+END PGP SIGNATURE-+$", $contents)) {
            $this->pgpType = static::PGP_CLEARSIGN;
            return $this->closeCase("asc", "text/plain");
        }
        elseif (mb_ereg_match("^-+BEGIN PGP SIGNATURE-+.*-+END PGP SIGNATURE-+$", $contents)) {
            $this->pgpType = static::PGP_SIGNATURE;
            return $this->closeCase("asc", "text/plain");
        }

        return null;
    }

    public function isPgp()
    {
        return !is_null($this->pgpType);
    }

    public function getPgpType()
    {
        return $this->pgpType;
    }

    /**
     * Can this file type potentially cause damage or intrude on a user's privacy?
     * This means executable programs, or file formats that can contact remote servers in any way (even SVGs).
     *
     * @return boolean
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function isRisky()
    {
        parent::isRisky();

        return false;
    }

    public static function on()
    {
        return function_exists("mb_ereg_match");
    }
}
