<?php
namespace Coercive\App\Service;

use Iterator;
use Countable;
use ArrayAccess;

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
class Container implements ArrayAccess, Iterator, Countable
{
	/** @var array Array access values list */
	private $array = [];

	/** @var array Array access processed status */
	private $prepared = [];

	/** @var int Position in array */
	private $position = 0;

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
	 * Creates a copy of array
	 *
	 * @return array
	 */
	public function getArrayCopy(): array
	{
		return $this->array;
	}

	/**
	 * Sort the entries by value
	 *
	 * @return $this
	 */
	public function asort()
	{
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
			if($this->position) {
				--$this->position;
			}
		}
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
	 * @inheritdoc
	 * @see Iterator::current
	 *
	 * @return mixed
	 */
	public function current()
	{
		return array_values(array_slice($this->array, $this->position, 1, true))[0] ?? null;
	}

	/**
	 * @inheritdoc
	 * @see Iterator::next
	 *
	 * @return void
	 */
	public function next()
	{
		++$this->position;
	}

	/**
	 * @inheritdoc
	 * @see Iterator::key
	 *
	 * @return void
	 */
	public function key()
	{
		return array_keys(array_slice($this->array, $this->position, 1, true))[0] ?? null;
	}

	/**
	 * @inheritdoc
	 * @see Iterator::valid
	 *
	 * @return bool
	 */
	public function valid(): bool
	{
		return [] !== array_slice($this->array, $this->position, 1);
	}

	/**
	 * @inheritdoc
	 * @see Iterator::rewind
	 *
	 * @return void
	 */
	public function rewind()
	{
		# Reinit
		$this->position = 0;

		# Reorder
		reset($this->array);
	}
}
