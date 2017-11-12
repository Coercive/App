<?php
namespace Coercive\App\Factory;

use Coercive\App\Core\AbstractApp;
use Coercive\App\Settings\Config;
use Coercive\App\Service\Locale;
use Coercive\App\Service\Includer;
use Coercive\App\Exception\ServiceAccessException;

/**
 * Service Access
 *
 * @package Coercive\App\Factory
 * @author Anthony Moral <contact@coercive.fr>
 *
 * @property Config $Config
 * @property Locale $Locale
 * @property Includer $Includer
 */
abstract class AbstractServiceAccess {

	/** @var AbstractApp */
	public $app = null;

	/**
	 * AUTO GET SERVICE
	 *
	 * @param string $sName
	 * @return object
	 * @throws ServiceAccessException
	 */
	public function __get($sName) {

		# OBJECT PROPERTY
		if(isset($this->app->{$sName})) { return $this->app->{$sName}; }

		# ARRAY ACCESS
		if(isset($this->app[$sName])) { return $this->app[$sName]; }

		# UNDEFINED SERVICE
		throw new ServiceAccessException("Service is not defined : $sName.");

	}

	/**
	 * AbstractServiceAccess constructor.
	 *
	 * @param AbstractApp $app
	 */
	public function __construct(AbstractApp $app) {

		$this->app = $app;

	}

}