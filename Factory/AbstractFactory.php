<?php
namespace Coercive\App\Factory;

use ReflectionClass;
use ReflectionException;
use Coercive\App\Core\AbstractApp;
use Coercive\App\Settings\FactoryInterface;
use Coercive\App\Exception\FactoryException;

/**
 * Factory
 *
 * @package 	Coercive\App\Factory
 * @link		https://github.com/Coercive/App
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @license 	MIT
 */
abstract class AbstractFactory implements FactoryInterface
{
	/**
	 * Single instance of any loaded class
	 *
	 * @var array Class SINGLETON
	 */
	protected $instances = [];

	/** @var string Namespace */
	protected $namespace;

	/** @var AbstractApp $app */
	protected $app;

	/**
	 * AbstractFactory constructor.
	 *
	 * @param AbstractApp $app
	 */
	public function __construct(AbstractApp $app)
	{
		# Bind App
		$this->app = $app;
	}

	/**
	 * Class Loader
	 *
	 * @param string $name
	 * @param array $arguments [optional]
	 * @return mixed
	 * @throws FactoryException
	 * @throws ReflectionException
	 */
	public function __call($name, $arguments = [])
	{
		# Namespace directory
		$this->namespace = $this->getNamespace($name);
		if(!$this->namespace) {
			throw new FactoryException('Empty factory namespace given.');
		}

		# Class + Namespace
		$class = $this->namespace . '\\' . $name;

		# Already loaded
		if (isset($this->instances[$class])) { return $this->instances[$class]; }

		# Undefined class
		if (!class_exists($class)) {
			throw new FactoryException("Try to call undefined class : $class.");
		}

		# Reflection
		$reflexion = new ReflectionClass($class);

		# Class not instantiable (private or protected constructor)
		if (!$reflexion->isInstantiable()) {
			throw new FactoryException("Class not instantiable : $class.");
		}

		# Constructor detail
		$constructor = $reflexion->getConstructor();

		# No constructor declared
		if (null === $constructor) {
			return $this->instances[$class] = $reflexion->newInstanceWithoutConstructor();
		}

		# No constructor params
		if (!$constructor->getNumberOfParameters()) {
			return $this->instances[$class] = $reflexion->newInstance();
		}

		# Detect if constructor required App
		$expectedApp = false;
		foreach ($constructor->getParameters() as $parameter) {
			if ($parameter->getName() === 'app') {
				$expectedApp = true;
			}
		}

		# Constructor does not require App
		if (!$expectedApp) {
			return $this->instances[$class] = $reflexion->newInstanceArgs($arguments);
		}

		# Constructor require App
		array_unshift($arguments, $this->app);
		return $this->instances[$class] = $reflexion->newInstanceArgs($arguments);
	}
}