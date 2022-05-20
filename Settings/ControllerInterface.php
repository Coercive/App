<?php
namespace Coercive\App\Settings;

/**
 * Controller Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface ControllerInterface
{
	/**
	 * Full template load
	 *
	 * Used for render your web page at the end of controller process
	 *
	 * @param string $path
	 * @param array $data [optional]
	 */
	public function render(string $path, array $data = []);

	/**
	 * Behavior during an ajax request
	 *
	 * @param mixed $data
	 * @return void
	 */
	public function ajax($data);

	/**
	 * Useful direct JSON rendering
	 *
	 * @param mixed $data
	 * @return void
	 */
	public function json($data);

	/**
	 * Useful direct XML rendering
	 *
	 * @param mixed $data
	 * @return void
	 */
	public function xml($data);

	/**
	 * Useful direct HTML part rendering
	 *
	 * @param mixed $data
	 * @return void
	 */
	public function html($data);
}
