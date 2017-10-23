<?php
namespace Coercive\App\Factory;

use Coercive\App\Core\App;
use Coercive\App\Exception\ServiceAccessException;

/**
 * Service Access
 *
 * @package 	Coercive\App\Factory
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2017 - 2018 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
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

		/**
		 *
		 * @todo utiliser un objet Service à la place de cette merde
		 *
		 */

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