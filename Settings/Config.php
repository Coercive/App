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
	const CONSTANTES = 'CONSTANTES';
	const LANGUAGES = 'LANGUAGES';
	const LANGUAGE = 'LANGUAGE';
	const LOCALE = 'LOCALE';
	const CRYPT = 'CRYPT';
	const CURRENCY = 'CURRENCY';
	const PRICE_DIGITS = 'PRICE_DIGITS';

	# PROJECT
	const PROJECT_ID = 'PROJECT_ID';
	const PROJECT_NAME = 'PROJECT_NAME';
	const PROJECT_NAMESPACE = 'PROJECT_NAMESPACE';
	const EMAIL = 'EMAIL';
	const EMAILS = 'EMAILS';
	const EMAIL_WEBMASTER = 'EMAIL_WEBMASTER';
	const EMAIL_WEBMASTERS = 'EMAIL_WEBMASTERS';
	const EMAIL_STATUS = 'EMAIL_STATUS';
	const EMAIL_FROM = 'EMAIL_FROM';

	# HOST
	const HOST = 'HOST';
	const SCRIPT_FILENAME = 'SCRIPT_FILENAME';
	const DOCUMENT_ROOT = 'DOCUMENT_ROOT';
	const REQUEST_SCHEME = 'REQUEST_SCHEME';

	# ENV
	const ENV = 'ENV';
	const TEST_MODE = 'TEST_MODE';

	# PATH
	const PUBLIC_DATA_DIRECTORY = 'PUBLIC_DATA_DIRECTORY';
	const DATA_DIRECTORY = 'DATA_DIRECTORY';
	const FILE_DIRECTORY = 'FILE_DIRECTORY';
	const PUBLIC_FILE_DIRECTORY = 'PUBLIC_FILE_DIRECTORY';
	const PUBLIC_DIRECTORY = 'PUBLIC_DIRECTORY';
	const WEBSITE_DIRECTORY = 'WEBSITE_DIRECTORY';
	const TMP_DIRECTORY = 'TMP_DIRECTORY';

	# OPTIONAL BIND SYSTEM
	const SESSION_CONFIG = 'SESSION_CONFIG';
	const CACHE_STATUS = 'CACHE_STATUS';
	const COOKIE_STATUS = 'COOKIE_STATUS';
	const RATELIMIT_STATUS = 'RATELIMIT_STATUS';
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
	 * SETTER : CONSTANTES
	 *
	 * @param array $constantes
	 * @return $this
	 */
	public function setConstantes(array $constantes): Config
	{
		$this->datas[self::CONSTANTES] = $constantes;
		return $this;
	}

	/**
	 * GETTER : CONSTANTES
	 *
	 * @return array
	 */
	public function getConstantes(): array
	{
		return $this->datas[self::CONSTANTES] ?? [];
	}

	/**
	 * SETTER : LANGUAGES
	 *
	 * @param array $languages
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
	 * @param bool $full [optional] return full label, not only ISO country
	 * @return array
	 */
	public function getLanguages(bool $full = true): array
	{
		if($full) {
			return $this->datas[self::LANGUAGES] ?? [];
		}
		else {
			$stack = [];
			foreach ($this->datas[self::LANGUAGES] ?? [] as $lang) {
				$stack[] = substr($lang, -2, 2);
			}
			return $stack;
		}
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
	 * @param bool $full [optional] return full label, not only ISO country
	 * @return string
	 */
	public function getLanguage(bool $full = false): string
	{
		$lang = strval($this->datas[self::LANGUAGE] ?? '');
		return $full ? $lang : substr($lang, -2, 2);
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
		return $this->datas[self::LOCALE][$this->getLanguage(true)] ?? [];
	}

	/**
	 * RESET : LOCALES
	 *
	 * @return $this
	 */
	public function setDefaultLocales(): Config
	{
		$this->datas[self::LOCALE] = [
			'FR' => [
				'fr', 'FR', 'fr_FR', 'fr_FR.utf8', 'fr_FR.utf-8', 'fra'
			],
			'EN' => [
				'en', 'EN', 'en_EN', 'en_EN.utf8', 'en_EN.utf-8', 'eng'
			],
			'ES' => [
				'es', 'ES', 'es_ES', 'es_ES.utf8', 'es_ES.utf-8', 'esp'
			],
			'IT' => [
				'it', 'IT', 'it_IT', 'it_IT.utf8', 'it_IT.utf-8', 'ita'
			]
		];
		return $this;
	}

	/**
	 * SETTER : CURRENCY
	 *
	 * @param string $code
	 * @return $this
	 */
	public function setCurrency(string $code): Config
	{
		$this->datas[self::CURRENCY] = $code;
		return $this;
	}

	/**
	 * GETTER : CURRENCY
	 *
	 * @return string
	 */
	public function getCurrency(): string
	{
		return strval($this->datas[self::CURRENCY] ?? '');
	}

	/**
	 * SETTER : PRICE_DIGITS
	 *
	 * @param int $nb
	 * @return $this
	 */
	public function setPriceDigits(int $nb): Config
	{
		$this->datas[self::PRICE_DIGITS] = $nb;
		return $this;
	}

	/**
	 * GETTER : PRICE_DIGITS
	 *
	 * @param bool $isset [optional] show -1 if not set
	 * @return int
	 */
	public function getPriceDigits(bool $isset = false): int
	{
		$i = $this->datas[self::PRICE_DIGITS] ?? null;
		return $isset && null === $i ? -1 : intval(abs($i));
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
	 * SETTER : EMAIL_WEBMASTERS
	 *
	 * @param array $emails
	 * @return $this
	 */
	public function setEmailWebmasters(array $emails): Config
	{
		$this->datas[self::EMAIL_WEBMASTERS] = $emails;
		return $this;
	}

	/**
	 * GETTER : EMAIL_WEBMASTERS
	 *
	 * @return array
	 */
	public function getEmailWebmasters(): array
	{
		return (array) ($this->datas[self::EMAIL_WEBMASTERS] ?? []);
	}

	/**
	 * SETTER : EMAIL
	 *
	 * @param string $email
	 * @return $this
	 */
	public function setEmail(string $email): Config
	{
		$this->datas[self::EMAIL] = $email;
		return $this;
	}

	/**
	 * GETTER : EMAIL
	 *
	 * @return string
	 */
	public function getEmail(): string
	{
		return strval($this->datas[self::EMAIL] ?? '');
	}

	/**
	 * SETTER : EMAIL_FROM
	 *
	 * @param string $email
	 * @return $this
	 */
	public function setEmailFrom(string $email): Config
	{
		$this->datas[self::EMAIL_FROM] = $email;
		return $this;
	}

	/**
	 * GETTER : EMAIL_FROM
	 *
	 * @return string
	 */
	public function getEmailFrom(): string
	{
		return strval($this->datas[self::EMAIL_FROM] ?? '');
	}

	/**
	 * SETTER : EMAILS
	 *
	 * @param array $emails
	 * @return $this
	 */
	public function setEmails(array $emails): Config
	{
		$this->datas[self::EMAILS] = $emails;
		return $this;
	}

	/**
	 * GETTER : EMAILS
	 *
	 * @return array
	 */
	public function getEmails(): array
	{
		return (array) ($this->datas[self::EMAILS] ?? []);
	}

	/**
	 * SETTER : EMAIL_STATUS
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setEmailStatus(bool $status): Config
	{
		$this->datas[self::EMAIL_STATUS] = $status;
		return $this;
	}

	/**
	 * GETTER : EMAIL_STATUS
	 *
	 * @return bool
	 */
	public function getEmailStatus(): bool
	{
		return boolval($this->datas[self::EMAIL_STATUS] ?? false);
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
	 * SETTER : DATA DIRECTORY
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setDataDirectory(string $path): Config
	{
		$this->datas[self::DATA_DIRECTORY] = $path;
		return $this;
	}

	/**
	 * GETTER : DATA DIRECTORY
	 *
	 * @return string
	 */
	public function getDataDirectory(): string
	{
		return strval($this->datas[self::DATA_DIRECTORY] ?? '');
	}

	/**
	 * SETTER : PUBLIC DATA DIRECTORY
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setPublicDataDirectory(string $path): Config
	{
		$this->datas[self::PUBLIC_DATA_DIRECTORY] = $path;
		return $this;
	}

	/**
	 * GETTER : PUBLIC DATA DIRECTORY
	 *
	 * @return string
	 */
	public function getPublicDataDirectory(): string
	{
		return strval($this->datas[self::PUBLIC_DATA_DIRECTORY] ?? '');
	}

	/**
	 * SETTER : FILE DIRECTORY
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setFileDirectory(string $path): Config
	{
		$this->datas[self::FILE_DIRECTORY] = $path;
		return $this;
	}

	/**
	 * GETTER : FILE DIRECTORY
	 *
	 * @return string
	 */
	public function getFileDirectory(): string
	{
		return strval($this->datas[self::FILE_DIRECTORY] ?? '');
	}

	/**
	 * SETTER : PUBLIC FILE DIRECTORY
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setPublicFileDirectory(string $path): Config
	{
		$this->datas[self::PUBLIC_FILE_DIRECTORY] = $path;
		return $this;
	}

	/**
	 * GETTER : PUBLIC FILE DIRECTORY
	 *
	 * @return string
	 */
	public function getPublicFileDirectory(): string
	{
		return strval($this->datas[self::PUBLIC_FILE_DIRECTORY] ?? '');
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
	 * SETTER : TMP DIRECTORY
	 *
	 * @param string $path
	 * @return $this
	 */
	public function setTmpDirectory(string $path): Config
	{
		$this->datas[self::TMP_DIRECTORY] = $path;
		return $this;
	}

	/**
	 * GETTER : TMP DIRECTORY
	 *
	 * @return string
	 */
	public function getTmpDirectory(): string
	{
		return strval($this->datas[self::TMP_DIRECTORY] ?? '');
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

	/**
	 * SETTER : COOKIE STATUS
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setCookieStatus(bool $status): Config
	{
		$this->datas[self::COOKIE_STATUS] = $status;
		return $this;
	}

	/**
	 * GETTER : COOKIE STATUS
	 *
	 * @return bool
	 */
	public function getCookieStatus(): bool
	{
		return boolval($this->datas[self::COOKIE_STATUS] ?? false);
	}

	/**
	 * SETTER : RATE LIMIT STATUS
	 *
	 * @param bool $status
	 * @return $this
	 */
	public function setRateLimitStatus(bool $status): Config
	{
		$this->datas[self::RATELIMIT_STATUS] = $status;
		return $this;
	}

	/**
	 * GETTER : RATE LIMIT STATUS
	 *
	 * @return bool
	 */
	public function getRateLimitStatus(): bool
	{
		return boolval($this->datas[self::RATELIMIT_STATUS] ?? false);
	}
}
