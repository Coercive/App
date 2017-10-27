<?php
namespace Coercive\App\Factory;

use Coercive\App\Core\App;
use Coercive\App\Exception\ServiceAccessException;

/**
 * Service Access
 *
 * @package 	Coercive\App\Factory
 * @author  	Anthony Moral <contact@coercive.fr>
 */
abstract class AbstractServiceAccess {

	/** @var App */
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
	 * @param App $app
	 */
	public function __construct(App $app) {

		$this->app = $app;

	}

}