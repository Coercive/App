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
	 * @param array $path
	 * @param array $data [optional]
	 */
	public function render(array $path, array $data = []);

	/**
	 * Behavior during an ajax request
	 *
	 * @param mixed $data
	 */
	public function ajax($data);

	/**
	 * Useful direct JSON rendering
	 *
	 * @param mixed $data
	 */
	public function json($data);
}