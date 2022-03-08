<?php
namespace Coercive\App\Service;

/**
 * Escaper
 *
 * @package Coercive\App\Service
 * @author Anthony Moral <contact@coercive.fr>
 */
class Escaper
{
	const CH = 'CH';
	const DE = 'DE';
	const EN = 'EN';
	const ES = 'ES';
	const FR = 'FR';
	const GR = 'GR';
	const IT = 'IT';
	const NL = 'NL';
	const PL = 'PL';
	const PT = 'PT';
	const RU = 'RU';
	const SE = 'SE';

	const SPACES = [
		'thin_html5' => '&ThinSpace;', # fine space html5
		'thin' => '&thinsp;', # fine space
		'nb' => '&nbsp;', # insecable non breaking
		'en' => '&ensp;', # 2 spaces en size
		'em' => '&emsp;', # 4 spaces em size
		'ndash' => '&ndash;', # n size dash
		'mdash' => '&mdash;', # m size dash
	];

	/** @var string Current locale in use */
	private $locale;

	/** @var array spaces in utf8 */
	private $spaces;

	/**
	 * Pre-compute some var
	 *
	 * @return Escaper
	 */
	private function prepare(): Escaper
	{
		foreach (self::SPACES as $name => $entity) {
			$this->spaces[$name] = html_entity_decode($entity, ENT_HTML5, 'UTF-8');
		}
		return $this;
	}

	/**
	 * Escaper constructor.
	 *
	 * @param string $locale [optional]
	 * @return void
	 */
	public function __construct(string $locale = '')
	{
		# Init locale
		$this->setLocale($locale);

		# Prepare chars
		$this->prepare();
	}

	/**
	 * Allow to set your own locale
	 *
	 * @param string $locale
	 * @return $this
	 */
	public function setLocale(string $locale): Escaper
	{
		$locale = strtoupper($locale);
		if(preg_match('`^[A-Z]{2}$`', $locale))
		{
			$this->locale = $locale;
		}
		else
		{
			$this->locale = self::EN;
		}
		return $this;
	}

	/**
	 * Dactylo to typo quote
	 *
	 * @link https://www.brunobernard.com/utilisez-les-bons-guillemets-typographiques/
	 *
	 * @param string $str
	 * @return string
	 */
	public function typographicQuotationMarks(string $str): string
	{
		switch ($this->locale)
		{
			case self::FR:
				$open = '«' . $this->spaces['thin'];
				$close = $this->spaces['thin'] . '»';
				break;
			case self::CH:
			case self::ES:
			case self::GR:
			case self::IT:
			case self::PT:
			case self::RU:
				$open = '«';
				$close = '»';
				break;
			case self::DE:
				$open = '„';
				$close = '“';
				break;
			case self::PL:
				$open = '„';
				$close = '”';
				break;
			case self::NL:
				$open = '‘';
				$close = '’';
				break;
			case self::SE:
				$open = '”';
				$close = '”';
				break;
			case self::EN:
			default:
				$open = '“';
				$close = '”';
				break;
		}

		# Transform quotation marks
		$str = preg_replace('`(^|\s|\()"([^"]+)"`im', '$1'. $open . '$2' . $close, $str);
		$str = str_replace('"', $open, $str);

		# Delete duplicate spaces
		$str = str_replace($open . ' ', $open, $str);
		$str = str_replace(' ' . $close, $close, $str);

		return $str;
	}

	/**
	 * Dactylo to empty
	 *
	 * @param string $str
	 * @return string
	 */
	public function removeQuotationMarks(string $str): string
	{
		return str_replace('"', '', $str);
	}

	/**
	 * Dactylo to typo quote
	 *
	 * @param string $str
	 * @return string
	 */
	public function typographicApostropheMarks(string $str): string
	{
		return str_replace("'", '’', $str);
	}

	/**
	 * Dactylo to empty
	 *
	 * @param string $str
	 * @return string
	 */
	public function removeApostropheMarks(string $str): string
	{
		return str_replace("'", '', $str);
	}

	/**
	 * Format spaces
	 *
	 * @param string $str
	 * @param string $replace [optional]
	 * @return string
	 */
	public function formatSpaces(string $str, string $replace = ' '): string
	{
		$str = str_replace($this->spaces, $replace, $str);
		$str = str_replace(self::SPACES, $replace, $str);
		return $str;
	}

	/**
	 * Encode string for html attributes
	 *
	 * @param string $str
	 * @param bool $striptags [optional]
	 * @return string
	 */
	public function htmlAttr(string $str, bool $striptags = true): string
	{
		$str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		if($striptags) {
			$str = strip_tags($str);
		}
		$str = $this->typographicQuotationMarks($str);
		$str = $this->typographicApostropheMarks($str);
		$str = $this->formatSpaces($str);
		return $str;
	}
}
