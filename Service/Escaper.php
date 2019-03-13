<?php
namespace Coercive\App\Service;

use Exception;
use Coercive\App\Factory\AbstractServiceAccess;

/**
 * Escaper
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Escaper extends AbstractServiceAccess
{
	/**
	 * Locales constantes for specific typograpic marks
	 * @param string
	 */
	const FR = 'FR';
	const EN = 'EN';

	/** @var string Current locale in use */
	static private $locale = self::EN;

	/**
	 * Set locale for handle specific typographic marks
	 * (default EN)
	 *
	 * @param string $locale
	 * @return void
	 */
	static public function setLocale(string $locale)
	{
		self::$locale = $locale;
	}

	/**
	 * The current locale is French
	 *
	 * @return bool
	 */
	static public function isFr(): bool
	{
		return self::FR === self::$locale;
	}

	/**
	 * The current locale is English
	 *
	 * @return bool
	 */
	static public function isEn(): bool
	{
		return self::EN === self::$locale;
	}

	/**
	 * Dactylo to typo quote
	 *
	 * @param string $str
	 * @return string
	 * @throws Exception
	 */
	static public function typographicQuotationMarks(string $str): string
	{
		if(self::isFr())
		{
			$open = '«';
			$close = '»';
		}
		elseif(self::isEn())
		{
			$open = '“';
			$close = '”';
		}
		else
		{
			throw new Exception('Locale error');
		}

		$str = preg_replace('`(^|\s|\()"([^"]+)"`im', '$1'. $open . '$2' . $close, $str);
		$str = str_replace('"', $open, $str);

		return $str;
	}

	/**
	 * Dactylo to empty
	 *
	 * @param string $str
	 * @return string
	 */
	static public function removeQuotationMarks(string $str): string
	{
		return str_replace('"', '', $str);
	}

	/**
	 * Dactylo to typo quote
	 *
	 * @param string $str
	 * @return string
	 * @throws Exception
	 */
	static public function typographicApostropheMarks(string $str): string
	{
		return str_replace("'", '’', $str);
	}

	/**
	 * Dactylo to empty
	 *
	 * @param string $str
	 * @return string
	 */
	static public function removeApostropheMarks(string $str): string
	{
		return str_replace("'", '', $str);
	}
}