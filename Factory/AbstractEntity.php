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
 * @copyright   2017 - 2018 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
abstract class AbstractEntity extends Container implements EntityInterface {

	/**
	 * AbstractEntity Constructor.
	 *
	 * @param array $aDatas [optional]
	 * @param AbstractApp $app [optional]
	 */
	abstract public function __construct(array $aDatas = [], AbstractApp $app = null);

	/**
	 * Entities Collection
	 *
	 * @param array $aDatas [optional]
	 * @param AbstractApp $app [optional]
	 * @return array
	 */
	static public function Collection(array $aDatas = [], AbstractApp $app = null) {
		foreach ($aDatas as $iKey => $aRowDatas) {
			$aDatas[$iKey] = new static($aRowDatas, $app);
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
