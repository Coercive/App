<?php
namespace Coercive\App\Factory;

use ReflectionClass;
use Coercive\App\Core\App;
use Coercive\App\Settings\FactoryInterface;
use Coercive\App\Exception\FactoryException;

/**
 * Factory
 *
 * @package 	Coercive\App\Factory
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2017 - 2018 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
abstract class AbstractFactory implements FactoryInterface {

	/**
	 * Single instance of any loaded class
	 *
	 * @var array Class SINGLETON
	 */
	protected $_aInstances = [];

	/** @var string NameSpace */
	protected $_sNameSpace;

	/** @var App $app */
	protected $app;

	/**
	 * AbstractFactory constructor.
	 *
	 * @param App $app
	 * @throws FactoryException
	 */
	public function __construct(App $app) {

		# Bind App
		$this->app = $app;

		# Namespace directory
		$this->_sNameSpace = $this->getNamespace();
		if(!$this->_sNameSpace) {
			throw new FactoryException('Empty factory namespace given.');
		}

	}

	/**
	 * Class Loader
	 *
	 * @param string $sName
	 * @param array $aCustomParams [optional]
	 * @return object Class
	 * @throws FactoryException
	 */
	public function __call($sName, $aCustomParams = []) {

		# Class + Namespace
		$sClass = $this->_sNameSpace . '\\' . $sName;

		# Already loaded
		if (isset($this->_aInstances[$sClass])) { return $this->_aInstances[$sClass]; }

		# Undefined class
		if (!class_exists($sClass)) {
			throw new FactoryException("Try to call undefined class : $sClass.");
		}

		# Reflection
		$oClass = new ReflectionClass($sClass);

		# Class not instantiable (private or protected constructor)
		if (!$oClass->isInstantiable()) {
			throw new FactoryException("Class not instantiable : $sClass.");
		}

		# Constructor detail
		$oConstructor = $oClass->getConstructor();

		# No constructor declared
		if (null === $oConstructor) {
			return $this->_aInstances[$sClass] = $oClass->newInstanceWithoutConstructor();
		}

		# Get constructor params
		$aParams = $oConstructor->getParameters();
		$iNbParams = $oConstructor->getNumberOfParameters();

		# No constructor params
		if (!$iNbParams) {
			return $this->_aInstances[$sClass] = $oClass->newInstance();
		}

		# Detect if constructor required App
		$bExpectedApp = false;
		foreach ($aParams as $oParam) {
			if ($oParam->getName() === 'app') {
				$bExpectedApp = true;
			}
		}

		# Constructor does not require App
		if (!$bExpectedApp) {
			return $this->_aInstances[$sClass] = $oClass->newInstanceArgs($aCustomParams);
		}

		# Constructor require App
		array_unshift($aCustomParams, $this->app);
		return $this->_aInstances[$sClass] = $oClass->newInstanceArgs($aCustomParams);

	}

}