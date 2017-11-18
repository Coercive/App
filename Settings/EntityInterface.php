<?php
namespace Coercive\App\Settings;

/**
 * Entity Interface
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
interface EntityInterface {

	/**
	 * Entity Collection
	 *
	 * @param array $aDatas [optional]
	 * @return array
	 */
	static public function Collection(array $aDatas = []);

}