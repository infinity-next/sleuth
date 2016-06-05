<?php namespace InfinityNext\Sleuth\Contracts;

interface DetectiveContract
{
	/**
	 * Check the file against our cases.
	 *
	 * @param  mixed  $file  File to check.
	 * @param  string|null  Mime type to verify against. Checks all possible if unset.
	 * @return boolean  True if we solved the case, false if not.
	 */
	public function check($file, $verify = null);

	/**
	 * Return the extension of a solved case.
	 *
	 * @return string
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function getExtension();

	/**
	 * Return any extra information the detective has on this case.
	 *
	 * @return array
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function getMetaData();

	/**
	 * Return the mime type of a solved case.
	 *
	 * @return string
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function getMimeType();

	/**
	 * Is this file audio?
	 * This should not return true in the case of archives with audio.
	 *
	 * @return boolean
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function isAudio();

	/**
	 * Are we as sure as we can be that we have solved the case?
	 *
	 * @return boolean
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function isCertain();

	/**
	 * Can this file type potentially cause damage or intrude on a user's privacy?
	 * This means executable programs, or file formats that can contact remote servers in any way (even SVGs).
	 *
	 * @return boolean
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function isRisky();

	/**
	 * Is this file video?
	 * This should return true even if the video has audio!
	 * This should not return true in the case of archives with video.
	 *
	 * @return boolean
	 * @throws \InfinityNext\Sleuth\Exceptions\CaseNotSolved
	 */
	public function isVideo();

	/**
	 * Can the system run this Detective?
	 *
	 * @return boolean  True if we can run, False if not.
	 */
	public static function on();
}
