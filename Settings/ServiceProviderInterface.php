<?php
namespace Coercive\App\Settings;

use Coercive\App\Core\App;

/**
 * Service Provider Interface
 *
 * @package 	Coercive\App\Settings
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2017 - 2018 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
interface ServiceProviderInterface {

	/**
	 * Registers services on the given application.
	 *
	 * This configure the current service before launch.
	 *
	 * @param App $oApp
	 * @return void
	 */
	public function register(App $oApp) ;

	/**
	 * Bootstraps the service.
	 *
	 * This start the service whenever it is requested.
	 *
	 * @param App $oApp
	 * @return void
	 */
	public function boot(App $oApp) ;

}