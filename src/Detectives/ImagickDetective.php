<?php

namespace InfinityNext\Sleuth\Detectives;

use InfinityNext\Sleuth\Contracts\DetectiveContract;
use InfinityNext\Sleuth\Traits\DetectiveTrait;

class ImagickDetective implements DetectiveContract
{
    use DetectiveTrait;

    /**
     * Checks if thise file is a PDF.
     *
     * @return boolean|null
     */
    protected function leadPDF()
    {
        if (preg_match("/^%PDF-1.\d+/", $this->getFileContents())) {
            return $this->closeCase("pdf", "application/pdf");
        }

        return null;
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

    /**
     * Can the system run this Detective?
     *
     * @return boolean  True if we can run, False if not.
     */
    public static function on()
    {
        return class_exists("imagick");
    }
}
