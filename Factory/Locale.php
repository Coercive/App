<?php
namespace Coercive\App\Factory;

use DateTime;
use DateTimeZone;

/**
 * Locale
 *
 * @package	Coercive\App\Factory
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Locale extends AbstractServiceAccess {

	/**
	 * ALIAS SET LOCALE
	 *
	 * @return void
	 */
	public function setLocale() {
		call_user_func_array('setlocale', array_merge([LC_ALL], $this->Config->getLocale()));
	}

	/**
	 * TIME ZONE SERVER
	 *
	 * @return DateTimeZone
	 */
	public function getServerTimeZone() {
		return new DateTimeZone(ini_get('date.timezone'));
	}

	/**
	 * ALIAS PHP strftime()
	 *
	 * @param string $sSqlDate
	 * @param string $sPattern [optional]
	 * @return string
	 */
	public function strftime($sSqlDate, $sPattern = "%A %d %B %Y %H:%M:%S") {
		$oDate = new DateTime($sSqlDate, $this->getServerTimeZone());
		return strftime($sPattern, $oDate->getTimestamp());
	}

	/**
	 * JET LAG DIFF SCRIPT/SERVER
	 *
	 * @return bool
	 */
	public function isJetLagScriptDiffers() {
		return (bool) strcmp(date_default_timezone_get(), ini_get('date.timezone'));
	}

}