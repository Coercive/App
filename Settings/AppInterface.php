<?php
namespace Coercive\App\Settings;

/**
 * App Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface AppInterface {

	/**
	 * AppInterface constructor.
	 *
	 * Inject and handle configuration parametters in App system
	 *
	 * @param Config $oConfig
	 */
	public function __construct(Config $oConfig);

	/**
	 * Bind a service to the App system
	 *
	 * @param callable $oCallable
	 * @return $this
	 */
	public function addService(callable $oCallable);

	/**
	 * Launch the App
	 *
	 * @return void
	 */
	public function run();

}