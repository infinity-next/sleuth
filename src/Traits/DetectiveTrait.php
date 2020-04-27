<?php

namespace InfinityNext\Sleuth\Traits;

use InfinityNext\Sleuth\Exceptions\CaseNotSolved;

trait DetectiveTrait
{
    /**
     * Is the case closed?
     *
     * @var boolean
     */
    protected $caseClosed = false;

    /**
     * Extenson string derived from a closed case.
     *
     * @var string
     */
    protected $extension;

    /**
     * The file this detective is investigating.
     *
     * @var mixed
     */
    protected $file;

    /**
     * The contents of the file this detective is investigating.
     *
     * @var mixed
     */
    protected $fileContents;

    /**
     * Meta data array derived from a closed case.
     *
     * @var string
     */
    protected $metadata;

    /**
     * Mime type string derived from a closed case.
     *
     * @var string
     */
    protected $mime;

    /**
     * Throws an exception if the case is not closed.
     *
     * @return void
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    protected function caseClosedOrFail()
    {
        if ($this->caseClosed !== true) {
            throw new CaseNotSolved;
        }
    }

    /**
     * Check the the file against our leads.
     *
     * @param  mixed  $file  File to check.
     * @param  string|null  $verify  Extension to verify against. Checks all possible if unset.
     * @return boolean  True if we solved the case, false if not.
     */
    public function check($file, $verify = null)
    {
        if ($this->prepareFile($file)) {
            $leads = $this->leads();

            if (!is_null($verify)) {
                if (isset($leads[$verify])) {
                    return $this->checkLead($leads[$verify]);
                }

                return false;
            }
            else {
                foreach ($leads as $lead) {
                    $results = $this->checkLead($lead);

                    // We're sure we've found something.
                    if ($results === true) {
                        return true;
                    }
                    // We're sure this detective can find nothing.
                    else if ($results === false) {
                        break;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Checks the file against a specific lead.
     *
     * @param  string  $lead  Lead name.
     * @return boolean  If this lead has closed the case.
     */
    protected function checkLead($lead)
    {
        return call_user_func([$this, $lead]);
    }

    /**
     * Closes the case by setting protected properties.
     *
     * @param  string  $ext  File extension.
     * @param  string  $mime  Mime type.
     * @param  array  $meta  Meta data, optional. Must be array.
     * @return boolean
     */
    protected function closeCase($ext, $mime, array $meta = array())
    {
        $this->caseClosed = true;
        $this->extension  = $ext;
        $this->mime       = $mime;
        $this->metadata   = $meta;
        return true;
    }

    /**
     * Return the extension of a solved case.
     *
     * @return string
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function getExtension()
    {
        $this->caseClosedOrFail();

        return $this->extension;
    }

    /**
     * Return any extra information the detective has on this case.
     *
     * @return array
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function getFileContents()
    {
        $this->fileContents = $this->fileContents ?? file_get_contents($this->file);

        return $this->fileContents;
    }

    /**
     * Return any extra information the detective has on this case.
     *
     * @return array
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function getMetaData()
    {
        $this->caseClosedOrFail();

        return $this->metadata;
    }

    /**
     * Return the mime type of a solved case.
     *
     * @return string
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function getMimeType()
    {
        $this->caseClosedOrFail();

        return $this->mime;
    }

    /**
     * Is this file audio?
     * This should not return true in the case of archives with audio.
     *
     * @return boolean
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function isAudio()
    {
        $this->caseClosedOrFail();

        return false;
    }

    /**
     * Are we as sure as we can be that we have solved the case?
     *
     * @return boolean
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function isCertain()
    {
        $this->caseClosedOrFail();

        return false;
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
        $this->caseClosedOrFail();

        return true;
    }

    /**
     * Is this file video?
     * This should return true even if the video has audio!
     * This should not return true in the case of archives with video.
     *
     * @return boolean
     * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function isVideo()
    {
        $this->caseClosedOrFail();

        return false;
    }

    /**
     * Returns an array of file extensions this detective has leads on.
     *
     * @return array  Of file extensions.
     */
    protected function leads()
    {
        // Pull a list of methods that have the leadEXT syntax.
        $leads = preg_grep('/^lead(?<ext>[A-Z0-9]+)$/', get_class_methods($this));
        // Organize them as an array where keys and values are the same thing.
        $leads = array_combine($leads, $leads);
        // Try to find an extension method from our file.
        $ext   = "lead" . strtoupper(pathinfo($this->file, PATHINFO_EXTENSION));

        // If that method exists,
        // bring it to the front of the array so that it is checked first.
        if (isset($leads[$ext])) {
            $newLeads = [ $ext => $leads[$ext] ];
            unset($leads[$ext]);
            $newLeads += $leads;
            $leads = $newLeads;
            unset($newleads);
        }

        return $leads;
    }

    /**
     * Readies the file for investigation.
     *
     * @param  mixed  $file  File to check.
     * @return boolean  True if we have successfully prepared the file.
     */
    public function prepareFile($file)
    {
        $this->file = $file;

        return !!$this->file;
    }
}
