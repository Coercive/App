<?php
namespace Coercive\App\Settings;

/**
 * App Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface AppInterface
{
	/**
	 * AppInterface constructor.
	 *
	 * Inject and handle configuration parametters in App system
	 *
	 * @param Config $config
	 */
	public function __construct(Config $config);

	/**
	 * Launch the App
	 *
	 * @return void
	 */
	public function run();

	/**
	 * STATIC APP
	 *
	 * The custom code to prepare the App object with options to not start the website
	 * Useful for external system
	 *
	 * @param Config $config
	 * @return $this
	 */
	static public function getApp(Config $config);

}