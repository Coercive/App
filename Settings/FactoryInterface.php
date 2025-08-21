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
	public function getNamespace(string $name): string;

	/**
	 * Return the namespace handled by the current factory
	 *
	 * @param string $name The name of called class
	 * @param object $instance The instance of called class
	 * @return $this
	 */
	public function setInstance(string $name, object $instance): self;
}
