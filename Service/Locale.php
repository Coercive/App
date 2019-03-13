<?php
namespace Coercive\App\Service;

use DateTime;
use DateTimeZone;
use Coercive\App\Factory\AbstractServiceAccess;

/**
 * Locale
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Locale extends AbstractServiceAccess
{
	/**
	 * ALIAS SET LOCALE
	 *
	 * @param array $locale
	 * @return $this
	 */
	public function set(array $locale = []): Locale
	{
		call_user_func_array('setlocale', array_merge([LC_ALL], $locale ?: $this->Config->getLocale()));
		return $this;
	}

	/**
	 * TIME ZONE SERVER
	 *
	 * @return DateTimeZone
	 */
	public function getServerTimeZone(): DateTimeZone
	{
		return new DateTimeZone(ini_get('date.timezone'));
	}

	/**
	 * ALIAS PHP strftime()
	 *
	 * @param string $sqlDate
	 * @param string $pattern [optional]
	 * @return string
	 */
	public function strftime(string $sqlDate, string $pattern = "%A %d %B %Y %H:%M:%S"): string
	{
		$date = new DateTime($sqlDate, $this->getServerTimeZone());
		return strftime($pattern, $date->getTimestamp());
	}

	/**
	 * JET LAG DIFF SCRIPT/SERVER
	 *
	 * @return bool
	 */
	public function isJetLagScriptDiffers(): bool
	{
		return (bool) strcmp(date_default_timezone_get(), ini_get('date.timezone'));
	}
}