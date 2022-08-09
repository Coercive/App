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

	/**
	 * List of day names in current locale
	 *
	 * @param int $start [optional]
	 * @return array
	 */
	public function getDayNames(int $start = 0): array
	{
		$range = range(0,6);
		foreach ($range as $r) {
			if($r < $start) {
				array_shift($range);
				$range[] = $r;
			}
		}
		$days = [];
		$j = 0;
		foreach ($range as $i) {
			$timestamp = strtotime("last sunday +$i day");
			$days[$i+1] = [
				'N-1' => $j,
				'N' => ++$j,
				'n-1' => $i,
				'n' => $i+1,
				'abbr' => strftime('%a', $timestamp),
				'full' => strftime('%A', $timestamp),
			];
		}
		return $days;
	}

	/**
	 * List of month names in current locale
	 *
	 * @param int $start [optional]
	 * @return array
	 */
	public function getMonthNames(int $start = 0): array
	{
		$range = range(0,11);
		foreach ($range as $r) {
			if($r < $start) {
				array_shift($range);
				$range[] = $r;
			}
		}
		$months = [];
		$y = (int) date('Y');
		$j = 0;
		foreach ($range as $i) {
			$timestamp = strtotime("$y-$i-01");
			$months[$i+1] = [
				'N-1' => $j,
				'N' => ++$j,
				'n-1' => $i,
				'n' => $i+1,
				'abbr' => strftime('%b', $timestamp),
				'full' => strftime('%B', $timestamp),
			];
		}
		return $months;
	}
}