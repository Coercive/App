<?php
namespace Coercive\App\Service;

use NumberFormatter;
use Coercive\App\Settings\Config;

/**
 * Currency
 *
 * @author Anthony Moral <contact@coercive.fr>
 */
class Currency
{
	const CURRENCY = NumberFormatter::CURRENCY;
	const DECIMAL = NumberFormatter::DECIMAL;

	const DEFAULT_CURRENCY = 'USD';
	const DEFAULT_LOCALE = 'en_US';
	const DEFAULT_DIGITS = 2;

	/** @var NumberFormatter */
	private $fmt = null;

	/** @var string */
	private $currency = self::DEFAULT_CURRENCY;

	/** @var string */
	private $locale = self::DEFAULT_LOCALE;

	/** @var int */
	private $digits = self::DEFAULT_DIGITS;

	/** @var bool */
	private $truncate = false;

	/**
	 * Initialiaze NumberFormatter object
	 *
	 * @param int $style [optional]
	 * @return void
	 */
	private function init(int $style = self::CURRENCY)
	{
		$this->fmt = new NumberFormatter($this->locale, $style);
		if($style === self::CURRENCY) {
			$this->fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->currency);
		}
	}

	/**
	 * Currency constructor.
	 *
	 * @param Config $config
	 * @return void
	 */
	public function __construct(Config $config)
	{
		if($lang = $config->getLanguage(true)) {
			$this->setLocale($lang);
		}
		if($currency = $config->getCurrency()) {
			$this->setCurrency($currency);
		}
		if(-1 !== ($digits = $config->getPriceDigits(true))) {
			$this->setDigits($digits);
		}
	}

	/**
	 * Override config locale
	 *
	 * @param string $code [optional]
	 * @return $this
	 */
	public function setLocale(string $code = self::DEFAULT_LOCALE): Currency
	{
		$this->locale = $code;
		return $this;
	}

	/**
	 * Override config currency
	 *
	 * @param string $code [optional]
	 * @return $this
	 */
	public function setCurrency(string $code = self::DEFAULT_CURRENCY): Currency
	{
		$this->currency = $code;
		return $this;
	}

	/**
	 * Override config price digits
	 *
	 * @param int $nb [optional]
	 * @return $this
	 */
	public function setDigits(int $nb = self::DEFAULT_DIGITS): Currency
	{
		$this->digits = $nb;
		return $this;
	}

	/**
	 * Truncate empty digits (like .00)
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setTruncate(bool $status): Currency
	{
		$this->truncate = $status;
		return $this;
	}

	/**
	 * Detect if number has decimal or not (like .00)
	 *
	 * @param float $number
	 * @return bool
	 */
	public function hasDecimal(float $number): bool
	{
		return $number === floatval(round($number));
	}

	/**
	 * Format your price to a compliant str
	 *
	 * @param float $price
	 * @param bool $symbol [optional]
	 * @param bool $truncate [optional]
	 * @return string
	 */
	public function format(float $price, bool $symbol = true, bool $truncate = true): string
	{
		$this->init($symbol ? self::CURRENCY : self::DECIMAL);

		$digits = $this->digits;
		if($truncate && $this->truncate && $this->hasDecimal($price)) {
			$digits = 0;
		}
		$this->fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $digits);

		return $this->fmt->formatCurrency($price, $this->currency);
	}
}