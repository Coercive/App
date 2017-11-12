<?php
namespace Coercive\App\Core;

use InvalidArgumentException;
use Coercive\App\Settings\Config;
use Coercive\App\Service\Container;
use Coercive\App\Settings\AppInterface;

/**
 * Class Abstract App
 *
 * Unus pro omnibus, omnes pro uno, nos autem fortes, nos unum sumus.
 *
 * @package Coercive\App\Core
 * @author  Anthony <contact@anthonymoral.fr>
 *
 * @property Config $Config
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
	 * Init Cache System
	 *
	 * The custom code for initialize cache (if wanted)
	 *
	 * @return void
	 */
	abstract protected function _initCache();

	/**
	 * Init Router System
	 *
	 * The custom code for initialize your custom router
	 * Example : you can use Coercive\Router system
	 *
	 * @return void
	 */
	abstract protected function _initRouter();

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