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
abstract class AbstractServiceAccess
{
	/** @var AbstractApp */
	public $app = null;

	/**
	 * AUTO GET SERVICE
	 *
	 * @param string $name
	 * @return mixed
	 * @throws ServiceAccessException
	 */
	public function __get(string $name)
	{
		# OBJECT PROPERTY
		if(isset($this->app->{$name})) { return $this->app->{$name}; }

		# ARRAY ACCESS
		if(isset($this->app[$name])) { return $this->app[$name]; }

		# UNDEFINED SERVICE
		throw new ServiceAccessException("Service is not defined : $name.");
	}

	/**
	 * AbstractServiceAccess constructor.
	 *
	 * @param AbstractApp $app
	 * @return void
	 */
	public function __construct(AbstractApp $app)
	{
		$this->app = $app;
	}
}