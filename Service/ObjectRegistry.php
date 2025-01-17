<?php
namespace Coercive\App\Service;

/**
 * Object Registry
 *
 * @package	Coercive\App\Service
 * @author Anthony Moral <contact@coercive.fr>
 */
class ObjectRegistry
{
	/** @var object[] */
	static private array $objects = [];

	/**
	 * @param object $obj
	 * @return void
	 */
	static public function register(object $obj): void
	{
		self::$objects[spl_object_id($obj)] = $obj;
	}

	/**
	 * @param int $id
	 * @return void
	 */
	static public function unregister(int $id): void
	{
		unset(self::$objects[$id]);
	}

	/**
	 * @return void
	 */
	static public function clearReferences(): void
	{
		self::$objects = [];
	}

	/**
	 * @param int $id
	 * @return object|null
	 */
	static public function get(int $id): ? object
	{
		return self::$objects[$id] ?? null;
	}
}