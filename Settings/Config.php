<?php
namespace Coercive\App\Settings;

use Coercive\Security\Session\Config as SessionConfig;

/**
 * Config
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Config
{
	# MISC
	const EXCEPTION = 'EXCEPTION';
	const LANGUAGES = 'LANGUAGES';
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
	const CACHE_STATUS = 'CACHE_STATUS';
	const DB_ACCESS = 'DB_ACCESS';

	/** @var array Configuration datas */
	private $datas = [];

	/**
	 * SETTER
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function set(string $key, $value): Config
	{
		$this->datas[$key] = $value;
		return $this;
	}

	/**
	 * GETTER
	 *
	 * @param string $key
	 * @return mixed|null
	 */
	public function get(string $key)
	{
		return $this->datas[$key] ?? null;
	}
	
	/**
	 * SETTER : EXCEPTION
	 *
	 * @param bool $activate
	 * @return $this
	 */
	public function setException(bool $activate): Config
	{
		$this->datas[self::EXCEPTION] = $activate;
		return $this;
	}

	/**
	 * GETTER : EXCEPTION
	 *
	 * @return bool
	 */
	public function getException(): bool
	{
		return boolval($this->datas[self::EXCEPTION] ?? false);
	}

	/**
	 * SETTER : LANGUAGES
	 *
	 * @param string $languages
	 * @return $this
	 */
	public function setLanguages(array $languages): Config
	{
		$this->datas[self::LANGUAGES] = $languages;
		return $this;
	}

	/**
	 * GETTER : LANGUAGES
	 *
	 * @return array
	 */
	public function getLanguages(): array
	{
		return $this->datas[self::LANGUAGES] ?? [];
	}

	/**
	 * SETTER : LANGUAGE
	 *
	 * @param string $language
	 * @return $this
	 */
	public function setLanguage(string $language): Config
	{
		$this->datas[self::LANGUAGE] = $language;
		return $this;
	}

	/**
	 * GETTER : LANGUAGE
	 *
	 * @return string
	 */
	public function getLanguage(): string
	{
		return strval($this->datas[self::LANGUAGE] ?? '');
	}

	/**
	 * SETTER : LOCALES
	 *
	 * @param array $locale
	 * @return $this
	 */
	public function setLocales(array $locale): Config
	{
		$this->datas[self::LOCALE] = $locale;
		return $this;
	}

	/**
	 * GETTER : LOCALE
	 *
	 * @return array
	 */
	public function getLocale(): array
	{
		return $this->datas[self::LOCALE][$this->getLanguage()] ?? [];
	}

	/**
	 * RESET : LOCALES
	 *
	 * @return $this
	 */
	public function resetLocales(): Config
	{
		$this->datas[self::LOCALE] = [
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
	 * @param string $crypt
	 * @return $this
	 */
	public function setCrypt(string $crypt): Config
	{
		$this->datas[self::CRYPT] = $crypt;
		return $this;
	}

	/**
	 * GETTER : CRYPT
	 *
	 * @return string
	 */
	public function getCrypt(): string
	{
		return strval($this->datas[self::CRYPT] ?? '');
	}

	/**
	 * SETTER : PROJECT_ID
	 *
	 * @param string $id
	 * @return $this
	 */
	public function setProjectId(string $id): Config
	{
		$this->datas[self::PROJECT_ID] = $id;
		return $this;
	}

	/**
	 * GETTER : PROJECT_ID
	 *
	 * @return string
	 */
	public function getProjectId(): string
	{
		return strval($this->datas[self::PROJECT_ID] ?? '');
	}

	/**
	 * SETTER : PROJECT_NAME
	 *
	 * @param string $name
	 * @return $this
	 */
	public function setProjectName(string $name): Config
	{
		$this->datas[self::PROJECT_NAME] = $name;
		return $this;
	}

	/**
	 * GETTER : PROJECT_NAME
	 *
	 * @return string
	 */
	public function getProjectName(): string
	{
		return strval($this->datas[self::PROJECT_NAME] ?? '');
	}

	/**
	 * SETTER : PROJECT_NAMESPACE
	 *
	 * @param string $namespace
	 * @return $this
	 */
	public function setProjectNamespace(string $namespace): Config
	{
		$this->datas[self::PROJECT_NAMESPACE] = $namespace;
		return $this;
	}

	/**
	 * GETTER : PROJECT_NAMESPACE
	 *
	 * @return string
	 */
	public function getProjectNamespace(): string
	{
		return strval($this->datas[self::PROJECT_NAMESPACE] ?? '');
	}

	/**
	 * SETTER : EMAIL_WEBMASTER
	 *
	 * @param string $email
	 * @return $this
	 */
	public function setEmailWebmaster(string $email): Config
	{
		$this->datas[self::EMAIL_WEBMASTER] = $email;
		return $this;
	}

	/**
	 * GETTER : EMAIL_WEBMASTER
	 *
	 * @return string
	 */
	public function getEmailWebmaster(): string
	{
		return strval($this->datas[self::EMAIL_WEBMASTER] ?? '');
	}

	/**
	 * SETTER : HOST
	 *
	 * @param string $host
	 * @return $this
	 */
	public function setHost(string $host): Config
	{
		$this->datas[self::HOST] = $host;
		return $this;
	}

	/**
	 * GETTER : HOST
	 *
	 * @return string
	 */
	public function getHost(): string
	{
		return strval($this->datas[self::HOST] ?? '');
	}

	/**
	 * SETTER : SCRIPT_FILENAME
	 *
	 * @param string $scriptFilename
	 * @return $this
	 */
	public function setScriptFilename(string $scriptFilename): Config
	{
		$this->datas[self::SCRIPT_FILENAME] = $scriptFilename;
		return $this;
	}

	/**
	 * GETTER : SCRIPT_FILENAME
	 *
	 * @return string
	 */
	public function getScriptFilename(): string
	{
		return strval($this->datas[self::SCRIPT_FILENAME] ?? '');
	}

	/**
	 * SETTER : DOCUMENT_ROOT
	 *
	 * @param string $documentRoot
	 * @return $this
	 */
	public function setDocumentRoot(string $documentRoot): Config
	{
		$this->datas[self::DOCUMENT_ROOT] = $documentRoot;
		return $this;
	}

	/**
	 * GETTER : DOCUMENT_ROOT
	 *
	 * @return string
	 */
	public function getDocumentRoot(): string
	{
		return strval($this->datas[self::DOCUMENT_ROOT] ?? '');
	}

	/**
	 * SETTER : REQUEST_SCHEME
	 *
	 * @param string $requestScheme
	 * @return $this
	 */
	public function setRequestScheme(string $requestScheme): Config
	{
		$this->datas[self::REQUEST_SCHEME] = $requestScheme;
		return $this;
	}

	/**
	 * GETTER : REQUEST_SCHEME
	 *
	 * @return string
	 */
	public function getRequestScheme(): string
	{
		return strval($this->datas[self::REQUEST_SCHEME] ?? '');
	}

	/**
	 * SETTER : ENV
	 *
	 * @param string $env
	 * @return $this
	 */
	public function setEnv(string $env): Config
	{
		$this->datas[self::ENV] = $env;
		return $this;
	}

	/**
	 * GETTER : ENV
	 *
	 * @return string
	 */
	public function getEnv(): string
	{
		return strval($this->datas[self::ENV] ?? '');
	}

	/**
	 * SETTER : TEST_MODE
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setTestMode(bool $status): Config
	{
		$this->datas[self::TEST_MODE] = $status;
		return $this;
	}

	/**
	 * GETTER : TEST_MODE
	 *
	 * @return bool
	 */
	public function getTestMode(): bool
	{
		return strval($this->datas[self::TEST_MODE] ?? false);
	}

	/**
	 * SETTER : WEBSITE_DIRECTORY
	 *
	 * @param string $websiteDirectory
	 * @return $this
	 */
	public function setWebsiteDirectory(string $websiteDirectory): Config
	{
		$this->datas[self::WEBSITE_DIRECTORY] = $websiteDirectory;
		return $this;
	}

	/**
	 * GETTER : WEBSITE_DIRECTORY
	 *
	 * @return string
	 */
	public function getWebsiteDirectory(): string
	{
		return strval($this->datas[self::WEBSITE_DIRECTORY] ?? '');
	}

	/**
	 * SETTER : PUBLIC DIRECTORY
	 *
	 * @param string $fullPath
	 * @return $this
	 */
	public function setPublicDirectory(string $fullPath): Config
	{
		$this->datas[self::PUBLIC_DIRECTORY] = $fullPath;
		return $this;
	}

	/**
	 * GETTER : PUBLIC DIRECTORY
	 *
	 * @return string
	 */
	public function getPublicDirectory(): string
	{
		return strval($this->datas[self::PUBLIC_DIRECTORY] ?? '');
	}

	/**
	 * SETTER : SESSION CONFIG
	 *
	 * @param SessionConfig $oConfig
	 * @return $this
	 */
	public function setSessionConfig(SessionConfig $oConfig): Config
	{
		$this->datas[self::SESSION_CONFIG] = $oConfig;
		return $this;
	}

	/**
	 * GETTER : SESSION CONFIG
	 *
	 * @return SessionConfig
	 */
	public function getSessionConfig()
	{
		return $this->datas[self::SESSION_CONFIG] ?? null;
	}
	
	/**
	 * SETTER : DB ACCESS
	 *
	 * @param mixed $oDb
	 * @return $this
	 */
	public function setDbAccess($oDb): Config
	{
		$this->datas[self::DB_ACCESS] = $oDb;
		return $this;
	}

	/**
	 * GETTER : DB ACCESS
	 *
	 * @return mixed
	 */
	public function getDbAccess()
	{
		return $this->datas[self::DB_ACCESS] ?? null;
	}

	/**
	 * SETTER : CACHE STATUS
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setCacheStatus(bool $status): Config
	{
		$this->datas[self::CACHE_STATUS] = $status;
		return $this;
	}

	/**
	 * GETTER : CACHE STATUS
	 *
	 * @return bool
	 */
	public function getCacheStatus(): bool
	{
		return boolval($this->datas[self::CACHE_STATUS] ?? false);
	}

}
