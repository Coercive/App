<?php
namespace Coercive\App\Settings;

use Coercive\Security\Session\Config as SessionConfig;

/**
 * Config
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Config {

	# MISC
	const LANGUAGE = 'LANGUAGE';
	const LOCALE = 'LOCALE';
	const CRYPT = 'CRYPT';

	# PROJECT
	const PROJECT_ID = 'PROJECT_ID';
	const PROJECT_NAME = 'PROJECT_NAME';
	const PROJECT_NAMESPACE = 'PROJECT_NAMESPACE';
	const EMAIL_WEBMASTER = 'EMAIL_WEBMASTER';

	# HOST
	const HOST = 'HOST';
	const SCRIPT_FILENAME = 'SCRIPT_FILENAME';
	const DOCUMENT_ROOT = 'DOCUMENT_ROOT';
	const REQUEST_SCHEME = 'REQUEST_SCHEME';

	# ENV
	const ENV = 'ENV';
	const TEST_MODE = 'TEST_MODE';

	# PATH
	const WEBSITE_DIRECTORY = 'WEBSITE_DIRECTORY';
	const PUBLIC_DIRECTORY = 'PUBLIC_DIRECTORY';

	# OPTIONAL BIND SYSTEM
	const SESSION_CONFIG = 'SESSION_CONFIG';

	/** @var array Configuration datas */
	private $_aDatas = [];

	/**
	 * SETTER
	 *
	 * @param string $sId
	 * @param mixed $mValue
	 * @return $this
	 */
	public function set($sId, $mValue) {
		$this->_aDatas[$sId] = $mValue;
		return $this;
	}

	/**
	 * GETTER
	 *
	 * @param string $sId
	 * @return string
	 */
	public function get($sId) {
		return $this->_aDatas[$sId] ?? '';
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

	/**
	 * SETTER : CRYPT
	 *
	 * @param string $sCrypt
	 * @return $this
	 */
	public function setCrypt($sCrypt) {
		$this->_aDatas[self::CRYPT] = (string) $sCrypt;
		return $this;
	}

	/**
	 * GETTER : CRYPT
	 *
	 * @return string
	 */
	public function getCrypt() {
		return $this->_aDatas[self::CRYPT] ?? '';
	}

	/**
	 * SETTER : PROJECT_ID
	 *
	 * @param string $sId
	 * @return $this
	 */
	public function setProjectId($sId) {
		$this->_aDatas[self::PROJECT_ID] = (string) $sId;
		return $this;
	}

	/**
	 * GETTER : PROJECT_ID
	 *
	 * @return string
	 */
	public function getProjectId() {
		return $this->_aDatas[self::PROJECT_ID] ?? '';
	}

	/**
	 * SETTER : PROJECT_NAME
	 *
	 * @param string $sName
	 * @return $this
	 */
	public function setProjectName($sName) {
		$this->_aDatas[self::PROJECT_NAME] = (string) $sName;
		return $this;
	}

	/**
	 * GETTER : PROJECT_NAME
	 *
	 * @return string
	 */
	public function getProjectName() {
		return $this->_aDatas[self::PROJECT_NAME] ?? '';
	}

	/**
	 * SETTER : PROJECT_NAMESPACE
	 *
	 * @param string $sNamespace
	 * @return $this
	 */
	public function setProjectNamespace($sNamespace) {
		$this->_aDatas[self::PROJECT_NAMESPACE] = (string) $sNamespace;
		return $this;
	}

	/**
	 * GETTER : PROJECT_NAMESPACE
	 *
	 * @return string
	 */
	public function getProjectNamespace() {
		return $this->_aDatas[self::PROJECT_NAMESPACE] ?? '';
	}

	/**
	 * SETTER : EMAIL_WEBMASTER
	 *
	 * @param string $sEmail
	 * @return $this
	 */
	public function setEmailWebmaster($sEmail) {
		$this->_aDatas[self::EMAIL_WEBMASTER] = (string) $sEmail;
		return $this;
	}

	/**
	 * GETTER : EMAIL_WEBMASTER
	 *
	 * @return string
	 */
	public function getEmailWebmaster() {
		return $this->_aDatas[self::EMAIL_WEBMASTER] ?? '';
	}

	/**
	 * SETTER : HOST
	 *
	 * @param string $sHost
	 * @return $this
	 */
	public function setHost($sHost) {
		$this->_aDatas[self::HOST] = (string) $sHost;
		return $this;
	}

	/**
	 * GETTER : HOST
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->_aDatas[self::HOST] ?? '';
	}

	/**
	 * SETTER : SCRIPT_FILENAME
	 *
	 * @param string $sScriptFilename
	 * @return $this
	 */
	public function setScriptFilename($sScriptFilename) {
		$this->_aDatas[self::SCRIPT_FILENAME] = (string) $sScriptFilename;
		return $this;
	}

	/**
	 * GETTER : SCRIPT_FILENAME
	 *
	 * @return string
	 */
	public function getScriptFilename() {
		return $this->_aDatas[self::SCRIPT_FILENAME] ?? '';
	}

	/**
	 * SETTER : DOCUMENT_ROOT
	 *
	 * @param string $sDocumentRoot
	 * @return $this
	 */
	public function setDocumentRoot($sDocumentRoot) {
		$this->_aDatas[self::DOCUMENT_ROOT] = (string) $sDocumentRoot;
		return $this;
	}

	/**
	 * GETTER : DOCUMENT_ROOT
	 *
	 * @return string
	 */
	public function getDocumentRoot() {
		return $this->_aDatas[self::DOCUMENT_ROOT] ?? '';
	}

	/**
	 * SETTER : REQUEST_SCHEME
	 *
	 * @param string $sRequestScheme
	 * @return $this
	 */
	public function setRequestScheme($sRequestScheme) {
		$this->_aDatas[self::REQUEST_SCHEME] = (string) $sRequestScheme;
		return $this;
	}

	/**
	 * GETTER : REQUEST_SCHEME
	 *
	 * @return string
	 */
	public function getRequestScheme() {
		return $this->_aDatas[self::REQUEST_SCHEME] ?? '';
	}

	/**
	 * SETTER : ENV
	 *
	 * @param string $sEnv
	 * @return $this
	 */
	public function setEnv($sEnv) {
		$this->_aDatas[self::ENV] = (string) $sEnv;
		return $this;
	}

	/**
	 * GETTER : ENV
	 *
	 * @return string
	 */
	public function getEnv() {
		return $this->_aDatas[self::ENV] ?? '';
	}

	/**
	 * SETTER : TEST_MODE
	 *
	 * @param bool $bTestMode
	 * @return $this
	 */
	public function setTestMode($bTestMode) {
		$this->_aDatas[self::TEST_MODE] = (bool) $bTestMode;
		return $this;
	}

	/**
	 * GETTER : TEST_MODE
	 *
	 * @return bool
	 */
	public function getTestMode() {
		return $this->_aDatas[self::TEST_MODE] ?? false;
	}

	/**
	 * SETTER : WEBSITE_DIRECTORY
	 *
	 * @param string $sWebsiteDirectory
	 * @return $this
	 */
	public function setWebsiteDirectory($sWebsiteDirectory) {
		$this->_aDatas[self::WEBSITE_DIRECTORY] = (string) $sWebsiteDirectory;
		return $this;
	}

	/**
	 * GETTER : WEBSITE_DIRECTORY
	 *
	 * @return string
	 */
	public function getWebsiteDirectory() {
		return $this->_aDatas[self::WEBSITE_DIRECTORY] ?? '';
	}

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
	 * SETTER : SESSION CONFIG
	 *
	 * @param SessionConfig $oConfig
	 * @return $this
	 */
	public function setSessionConfig(SessionConfig $oConfig) {
		$this->_aDatas[self::SESSION_CONFIG] = $oConfig;
		return $this;
	}

	/**
	 * GETTER : SESSION CONFIG
	 *
	 * @return string
	 */
	public function getSessionConfig() {
		return $this->_aDatas[self::SESSION_CONFIG] ?? '';
	}

}