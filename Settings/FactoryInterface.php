<?php
namespace Coercive\App\Settings;

/**
 * Factory Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface FactoryInterface
{
	/**
	 * Return the namespace handled by the current factory
	 *
	 * @param string $name The name of called method
	 * @return string
	 */
	public function getNamespace(string $name);
}
