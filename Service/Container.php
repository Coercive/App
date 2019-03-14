<?php
namespace Coercive\App\Service;

use Closure;
use Countable;
use ArrayAccess;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

/**
 * Container
 *
 * @package	Coercive\App\Service
 * @link https://github.com/Coercive/App
 *
 * @author Anthony Moral <contact@coercive.fr>
 * @copyright 2019 Anthony Moral
 * @license MIT
 */
class Container implements ArrayAccess, Countable, IteratorAggregate
{
	/** @var array Array access values list */
	private $array = [];

	/** @var array Array access processed status */
	private $prepared = [];

	/**
	 * Prepare Closures
	 *
	 * @return $this
	 */
	protected function prepare()
	{
		foreach ($this->array as $offset => $value)
		{
			# Detect closure or invoke
			if (isset($this->prepared[$offset])
				|| !is_object($this->array[$offset])
				|| !method_exists($this->array[$offset], '__invoke')
			) {
				continue;
			}

			# Invoke
			$this->array[$offset] = $this->array[$offset]($this);
			$this->prepared[$offset] = true;
		}
		return $this;
	}

	/**
	 * Replace actual content by new data
	 *
	 * @param array $data
	 * @return $this
	 */
	public function from(array $data)
	{
		$this->clear();
		$this->array = $data;
		return $this;
	}

	/**
	 * Empty internal array
	 *
	 * @return $this
	 */
	public function clear()
	{
		$this->array = [];
		$this->prepared = [];
		return $this;
	}

	/**
	 * Clean empty values
	 *
	 * @return $this
	 */
	public function clean()
	{
		return $this->from(array_filter($this->array));
	}

	/**
	 * Datalist for debug
	 *
	 * @return array
	 */
	public function __debugInfo(): array
	{
		return $this->array;
	}

	/**
	 * (GET) Property mode
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	public function __get($offset)
	{
		return $this->offsetGet($offset);
	}

	/**
	 * Alias of array copy
	 *
	 * @return array
	 */
	public function __invoke(): array
	{
		return $this->getArrayCopy();
	}

	/**
	 * Creates a copy of array
	 *
	 * @return array
	 */
	public function getArrayCopy(): array
	{
		return $this->array;
	}

	/**
	 * Convert array to json string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->serialize();
	}

	/**
	 * Convert array to json string
	 *
	 * @return string
	 */
	public function __toJson(): string
	{
		$this->prepare();
		return json_encode($this->array);
	}

	/**
	 * Export the object
	 *
	 * @return string
	 */
	public function serialize()
	{
		$this->prepare();
		return serialize($this->array);
	}

	/**
	 * Prepare the object with serialized datas
	 *
	 * @param string $serialized
	 * @return $this
	 */
	public function unserialize(string $serialized)
	{
		return $this->from(unserialize($serialized));
	}

	/**
	 * Convert array values to string
	 *
	 * @param string $separator
	 * @return string
	 */
	public function join(string $separator = ','): string
	{
		$this->prepare();
		return implode($separator, $this->array);
	}

	/**
	 * Remove by value
	 *
	 * @param mixed $value
	 * @param bool $strict
	 * @return $this
	 */
	public function remove($value, bool $strict = true)
	{
		$offset = $this->indexOf($value, $strict);
		if(null !== $offset) {
			$this->offsetUnset($offset);
		}
		return $this;
	}

	/**
	 * Slice internal array
	 *
	 * @param int $offset
	 * @param int $length [optional]
	 * @return Container
	 */
	public function slice(int $offset = 0, int $length = null)
	{
		if (null === $length) { $length = $this->count(); }
		return $this->from(array_slice($this->array, $offset, $length));
	}

	/**
	 * Sort the entries by value
	 *
	 * @return $this
	 */
	public function asort()
	{
		$this->prepare();
		asort($this->array);
		return $this;
	}

	/**
	 * Sort the entries by key
	 *
	 * @return $this
	 */
	public function ksort()
	{
		ksort($this->array);
		return $this;
	}

	/**
	 * Reverse the entries order
	 *
	 * @return $this
	 */
	public function reverse()
	{
		return $this->from(array_reverse($this->array, true));
	}

	/**
	 * Get the index of given value
	 *
	 * @param mixed $value
	 * @param bool $strict
	 * @return int|string|null
	 */
	public function indexOf($value, bool $strict = true)
	{
		$this->prepare();
		$index = array_search($value, $this->array, $strict);
		return $index !== false ? $index : null;
	}

	/**
	 * Detect if array contain the given value
	 *
	 * @param mixed $value
	 * @param bool $strict [optional]
	 * @return bool
	 */
	public function contains($value, bool $strict = true): bool
	{
		return in_array($value, $this->array, $strict);
	}

	/**
	 * Find by regexp
	 *
	 * @param string $pattern
	 * @param bool $keys [optional]
	 * @return array
	 */
	public function find(string $pattern, bool $keys = true): array
	{
		if(!$keys) {
			$this->prepare();
		}

		$results = [];
		foreach ($this->array as $key => $value)
		{
			if(preg_match($pattern, $keys ? $key : $value)) {
				$results[$key] = $value;
			}
		}
		return $results;
	}

	/**
	 * Append new item
	 *
	 * @param mixed $data
	 * @return $this
	 */
	public function append($data)
	{
		array_push($this->array, $data);
		return $this;
	}

	/**
	 * Merge with new array
	 *
	 * @param array $data
	 * @return $this
	 */
	public function merge(array $array)
	{
		$this->array = array_merge($this->array, $array);
		return $this;
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetExists
	 *
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset): bool
	{
		return array_key_exists($offset, $this->array);
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetGet
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		# Not exist
		if (!$this->offsetExists($offset)) {
			return null;
		}

		# Detect closure or invoke | return the others
		if (isset($this->prepared[$offset])
			|| !is_object($this->array[$offset])
			|| !method_exists($this->array[$offset], '__invoke')
		) {
			return $this->array[$offset];
		}

		# Prepare
		$this->array[$offset] = $this->array[$offset]($this);
		$this->prepared[$offset] = true;
		return $this->array[$offset];
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetSet
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return $this
	 */
	public function offsetSet($offset, $value)
	{
		$this->array[$offset] = $value;
		return $this;
	}

	/**
	 * Push a value to an existing offset
	 * Convert the offset if not already an array
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return $this
	 */
	public function offsetPush($offset, $value)
	{
		if($this->offsetExists($offset)) {
			$current = $this->offsetGet($offset);
			if(!is_array($current)) { $current = [$current]; }
			$this->array[$offset] = array_push($current, $value);
		}
		else {
			$this->array[$offset] = [$value];
		}
		return $this;
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetUnset
	 *
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		if ($this->offsetExists($offset)) {
			unset($this->array[$offset], $this->prepared[$offset]);
		}
	}

	/**
	 * @inheritdoc
	 * @see IteratorAggregate::getIterator
	 *
	 * @return ArrayIterator|Traversable
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->array);
	}

	/**
	 * @inheritdoc
	 * @see Countable::count
	 *
	 * @return int
	 */
	public function count(): int
	{
		return count($this->array);
	}

	/**
	 * Foreach callback
	 *
	 * @param Closure $function
	 * @return $this
	 */
	public function each(Closure $function)
	{
		foreach ($this->array as $key => $value)
		{
			$function($value, $key, $this);
		}
		return $this;
	}

	/**
	 * Map callback
	 *
	 * @param Closure $function
	 * @return $this
	 */
	public function map(Closure $function)
	{
		$results = [];
		foreach ($this->array as $key => $value)
		{
			$results[$key] = $function($value, $key, $this);
		}
		return $this->from($results);
	}

	/**
	 * Filter callback
	 *
	 * @param Closure $function
	 * @param bool $preserveKeys
	 * @return $this
	 */
	public function filter(Closure $function, bool $preserveKeys = false)
	{
		$results = [];
		foreach ($this->array as $key => $value)
		{
			if ($function($value, $key, $this)) {
				$preserveKeys ? $results[$key] = $value : $results[] = $value;
			}
		}
		return $this->from($results);
	}

	/**
	 * Every callback
	 *
	 * @param Closure $function
	 * @return bool
	 */
	public function every(Closure $function): bool
	{
		foreach($this as $key => $value)
		{
			if (!$function($value, $key, $this)) { return false; }
		}
		return true;
	}

	/**
	 * Some callback
	 *
	 * @param Closure $function
	 * @return bool
	 */
	public function some(Closure $function): bool
	{
		foreach($this as $key => $value)
		{
			if ($function($value, $key, $this)) { return true; }
		}
		return false;
	}
}
