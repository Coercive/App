<?php
namespace Coercive\App\Factory;

use Coercive\App\Service\Container;
use Coercive\App\Settings\EntityInterface;

/**
 * AbstractEntity
 *
 * @package 	Coercive\App\Factory
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2017 - 2018 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
abstract class AbstractEntity extends Container implements EntityInterface {

	/**
	 * AbstractEntity Constructor.
	 *
	 * @param array $aDatas [optional]
	 */
	abstract public function __construct(array $aDatas = []);

	/**
	 * Entities Collection
	 *
	 * @param array $aDatas
	 * @return array
	 */
	static public function Collection(array $aDatas = []) {
		foreach ($aDatas as $iKey => $aRowDatas) {
			$aDatas[$iKey] = new static($aRowDatas);
		}
		return $aDatas;
	}

	/**
	 * Auto set datas in entity
	 *
	 * @param array $aDatas
	 * @return void
	 */
	protected function _autoSet(array $aDatas) {
		foreach ($aDatas as $sFieldName => $mValue) {
			$this->offsetSet($sFieldName, $mValue);
		}
	}

}