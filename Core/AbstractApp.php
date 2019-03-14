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
 * @author Anthony <contact@anthonymoral.fr>
 * @copyright 2019 Anthony Moral
 * @license MIT
 *
 * @property Config $Config
 */
abstract class AbstractApp extends Container implements AppInterface
{
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
	public function __construct(Config $config)
	{
		$this['Config'] = $config;
	}

	/**
	 * GET SERVICE
	 *
	 * @param mixed $name
	 * @return mixed
	 */
	public function __get($name)
	{
		# PROPERTY
		if(isset($this->{$name})) { return $this->{$name}; }

		# SKIP ERROR
		if(!$this->offsetExists($name)) {
			throw new InvalidArgumentException('Service not found : ' . $name);
		}

		# GET SERVICE
		return $this->offsetGet($name);
	}
}
