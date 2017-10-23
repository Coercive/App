<?php
namespace Coercive\App\Settings;

use Coercive\App\Core\App;

/**
 * Service Provider Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
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