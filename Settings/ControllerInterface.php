<?php
namespace Coercive\App\Settings;

/**
 * Controller Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface ControllerInterface {

	/**
	 * Full template load
	 *
	 * Used for render your web page at the end of controller process
	 *
	 * @param array $aPath
	 * @param array $aData [optional]
	 */
	public function render($aPath, $aData = []);

	/**
	 * Behavior during an ajax request
	 *
	 * @param mixed $mData
	 */
	public function ajax($mData);

	/**
	 * Useful direct JSON rendering
	 *
	 * @param mixed $mData
	 */
	public function json($mData);

}