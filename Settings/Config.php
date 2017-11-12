<?php
namespace Coercive\App\Settings;

/**
 * Config
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Config {

	# PROPERTIES LIST
	const LANGUAGE = 'LANGUAGE';
	const LOCALE = 'LOCALE';
	const PUBLIC_DIRECTORY = 'PUBLIC_DIRECTORY';

	/** @var array Configuration datas */
	private $_aDatas = [];

	/**
	 * SETTER : PUBLIC DIRECTORY
	 *
	 * @param string $sFullPath
	 * @return $this
	 */
	public function setPublicDirectory($sFullPath) {
		$this->_aDatas[self::PUBLIC_DIRECTORY] = (string) $sFullPath;
		return $this;
	}

	/**
	 * GETTER : PUBLIC DIRECTORY
	 *
	 * @return string
	 */
	public function getPublicDirectory() {
		return $this->_aDatas[self::PUBLIC_DIRECTORY] ?? '';
	}

	/**
	 * SETTER : LANGUAGE
	 *
	 * @param string $sLanguage
	 * @return $this
	 */
	public function setLanguage($sLanguage) {
		$this->_aDatas[self::LANGUAGE] = (string) $sLanguage;
		return $this;
	}

	/**
	 * GETTER : LANGUAGE
	 *
	 * @return string
	 */
	public function getLanguage() {
		return $this->_aDatas[self::LANGUAGE] ?? '';
	}

	/**
	 * SETTER : LOCALES
	 *
	 * @param array $aLocale
	 * @return $this
	 */
	public function setLocales(array $aLocale) {
		$this->_aDatas[self::LOCALE] = (array) $aLocale;
		return $this;
	}

	/**
	 * GETTER : LOCALE
	 *
	 * @return array
	 */
	public function getLocale() {
		return $this->_aDatas[self::LOCALE][$this->getLanguage()] ?? [];
	}

	/**
	 * RESET : LOCALES
	 *
	 * @return $this
	 */
	public function resetLocales() {
		$this->_aDatas[self::LOCALE] = [
			'FR' => [
				'fr', 'FR', 'fr_FR', 'fr_FR.utf8', 'fr_FR.utf-8', 'fra'
			],
			'EN' => [
				'en', 'EN', 'en_EN', 'en_EN.utf8', 'en_EN.utf-8', 'eng'
			]
		];
		return $this;
	}

}