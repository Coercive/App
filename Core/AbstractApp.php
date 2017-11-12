<?php
namespace Coercive\App\Core;

use InvalidArgumentException;
use Coercive\App\Factory\Locale;
use Coercive\App\Settings\Config;
use Coercive\App\Factory\Includer;
use Coercive\App\Factory\Container;
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

	/** @var Config */
	protected $_oConfig;

	/**
	 * @inheritdoc
	 * @see AppInterface::__construct
	 */
	public function __construct(Config $oConfig) {

		$this->_oConfig = $oConfig;
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