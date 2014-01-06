<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use DateTime;
use DateInterval;
use DateTimeZone;

class Date {

	/**
	 * Store the users timezone
	 *
	 * @var string
	 */
	protected $tz;

	/**
	 * Store the date format
	 *
	 * @var string
	 */
	protected $format;

	/**
	 * Constructor
	 *
	 * @param string
	 * @param string
	 */
	public function __construct($tz, $format) {
		$this->tz = $tz;
		$this->format = $format;
	}

	/**
	 * Format a date from the database as UTC to users current timezone
	 *
	 * @param string
	 */
	public function format($date, $format = null) {
		$date = new DateTime($date, new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone($this->tz));

		return $date->format($format ?: $this->format);
	}

	/**
	 * Format a date from the users current timezone to the database as UTC
	 *
	 * @param string
	 */
	public function mysql($date) {
		$date = new DateTime($date, new DateTimeZone($this->tz));
		$date->setTimezone(new DateTimeZone('UTC'));

		return $date->format('Y-m-d H:i:s');
	}

}