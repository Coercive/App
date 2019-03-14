<?php
namespace Coercive\App\Factory;

use Coercive\App\Core\AbstractApp;
use Coercive\App\Service\Container;
use Coercive\App\Settings\EntityInterface;

/**
 * AbstractEntity
 *
 * @package 	Coercive\App\Factory
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2018 Anthony Moral
 * @license 	MIT
 */
abstract class AbstractEntity extends Container implements EntityInterface
{
	/**
	 * AbstractEntity Constructor.
	 *
	 * @param array $datas [optional]
	 * @param AbstractApp $app [optional]
	 */
	abstract public function __construct(array $datas = [], AbstractApp $app = null);

	/**
	 * Entities Collection
	 *
	 * @param array $datas [optional]
	 * @param AbstractApp $app [optional]
	 * @return array
	 */
	static public function Collection(array $datas = [], AbstractApp $app = null): array
	{
		foreach ($datas as $key => $item) {
			$datas[$key] = new static($item, $app);
		}
		return $datas;
	}
}
