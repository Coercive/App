<?php
namespace Coercive\App\Core;

use InvalidArgumentException;
use Coercive\App\Service\Locale;
use Coercive\App\Settings\Config;
use Coercive\App\Service\Includer;
use Coercive\App\Service\Container;
use Coercive\App\Settings\AppInterface;

/**
 * Abstract App
 *
 * @package	Coercive\App\Core
 * @author	Anthony Moral <contact@coercive.fr>
 *
 * @property Config $Config
 * @property Locale $Locale
 * @property Includer $Includer
 */
abstract class AbstractApp extends Container implements AppInterface {

	/**
	 * Transform PHP errors to Exception handler
	 *
	 * Example : you can use the Coercive\FatalNotifyer system or your custom code
	 *
	 * @return void
	 */
	abstract protected function _errorToException();

	/**
	 * SetUp Services
	 *
	 * Example : $this['OBJECT'] = function () use($oApp) { return new OBJECT(); };
	 *
	 * @return void
	 */
	abstract protected function _addServices();

	/**
	 * Init Services
	 *
	 * After add services you can add some code to init some services
	 *
	 * @return void
	 */
	abstract protected function _initServices();

	/**
	 * Manage Language
	 *
	 * The custom code for handle site language, bind for router, for locale etc...
	 *
	 * @return void
	 */
	abstract protected function _manageLanguage();

	/**
	 * The custom code launch just before app run
	 *
	 * @return void
	 */
	abstract protected function _beforeRun();

	/**
	 * The custom code launch just after app run
	 *
	 * @return void
	 */
	abstract protected function _afterRun();

	/**
	 * @inheritdoc
	 * @see AppInterface::__construct
	 */
	public function __construct(Config $oConfig) {

		$this['Config'] = function () use($oConfig) { return $oConfig; };

	}

	/**
	 * GET SERVICE
	 *
	 * @param string $sName
	 * @return object
	 */
	public function __get($sName) {

		# PROPERTY
		if(isset($this->{$sName})) { return $this->{$sName}; }

		# SKIP ERROR
		if(!isset($this[$sName])) {
			throw new InvalidArgumentException('Service not found : ' . $sName);
		}

		return $this[$sName];

	}

}