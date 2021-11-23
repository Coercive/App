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
	const DEFAULT_CURRENCY = 'USD';
	const DEFAULT_LOCALE = 'en_US';
	const DEFAULT_DIGITS = 2;

	private ? NumberFormatter $fmt = null;

	private string $currency = self::DEFAULT_CURRENCY;

	private string $locale = self::DEFAULT_LOCALE;

	private int $digits = self::DEFAULT_DIGITS;

	private bool $truncate = false;

	/**
	 * Initialiaze NumberFormatter object
	 *
	 * @param int $style [optional]
	 * @return void
	 */
	private function init(int $style = NumberFormatter::CURRENCY)
	{
		$this->fmt = new NumberFormatter($this->locale, $style);
		if($style === NumberFormatter::CURRENCY) {
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
		return $number !== floatval(round($number));
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
		$this->init($symbol ? NumberFormatter::CURRENCY : NumberFormatter::DECIMAL);

		$digits = $this->digits;
		if($truncate && $this->truncate && !$this->hasDecimal($price)) {
			$digits = 0;
		}
		$this->fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $digits);

		return $this->fmt->formatCurrency($price, $this->currency);
	}

	/**
	 * Explode price into array part : int / separator / dec / currency
	 *
	 * @param float $price
	 * @param bool $truncate [optional]
	 * @return array
	 */
	public function explode(float $price, bool $truncate = true): array
	{
		$arr['int'] = '';
		$arr['dec_separator'] = '';
		$arr['dec'] = '';
		$arr['currency_symbol'] = '';

		$price_formated = $this->format($price, false, $truncate);

		$this->fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->currency);
		$symbol = $this->fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

		if($truncate && $this->truncate && !$this->hasDecimal($price)) {
			$arr['int'] = $price_formated;
			$arr['dec_separator'] = '';
			$arr['dec'] = '';
			$arr['currency_symbol'] = $symbol;
			return $arr;
		}

		$sep = $this->fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
		if(preg_match("`^(.+)$sep(\d+)$`", $price_formated, $matches)) {
			$arr['int'] = $matches[1];
			$arr['dec_separator'] = $sep;
			$arr['dec'] = $matches[2];
			$arr['currency_symbol'] = $symbol;
			return $arr;
		}

		return $arr;
	}

	/**
	 * Format price into HTML
	 *
	 * @param float $price
	 * @param bool $truncate [optional]
	 * @return string
	 */
	public function htmlFormat(float $price, bool $truncate = true): string
	{
		$html_int = '<span class="int">{{int}}</span>';
		$html_dec_separator = '<span class="dec_separator">{{dec_separator}}</span>';
		$html_dec = '<span class="dec">{{dec}}</span>';
		$html_currency_symbol = '<span class="currency_symbol">{{currency_symbol}}</span>';

		$explode = $this->explode($price, $truncate);

		if(!$explode['dec_separator'] && !$explode['dec']) {
			$html = $html_int . $html_currency_symbol;
			$html = str_replace('{{int}}', $explode['int'], $html);
			$html = str_replace('{{currency_symbol}}', $explode['currency_symbol'], $html);
			return $html;
		}

		else {
			$html = $html_int . $html_dec_separator . $html_dec . $html_currency_symbol;
			$html = str_replace('{{int}}', $explode['int'], $html);
			$html = str_replace('{{dec_separator}}', $explode['dec_separator'], $html);
			$html = str_replace('{{dec}}', $explode['dec'], $html);
			$html = str_replace('{{currency_symbol}}', $explode['currency_symbol'], $html);
			return $html;
		}
	}
}