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
	/** @var array Array access keys list */
	private $keys = [];

	/** @var array Array access values list */
	private $values = [];

	/** @var array Array access processed status */
	private $prepared = [];

	/** @var int Position in array */
	private $position = 0;

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
	 * @inheritdoc
	 * @see ArrayAccess::offsetExists
	 *
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return (bool) array_keys($this->keys, $offset, true);
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
			|| !is_object($this->values[$offset])
			|| !method_exists($this->values[$offset], '__invoke')
		) {
			return $this->values[$offset];
		}

		# Prepare
		$this->values[$offset] = $this->values[$offset]($this);
		$this->prepared[$offset] = true;
		return $this->values[$offset];
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetSet
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->values[$offset] = $value;
		if(!$this->offsetExists($offset)) {
			$this->keys[] = $offset;
		}
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

			# Delete by key
			unset($this->values[$offset], $this->prepared[$offset]);

			# Delete by value
			foreach (array_keys($this->keys, $offset, true) as $key) {
				unset($this->keys[$key]);
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
		return count($this->keys);
	}

	/**
	 * @inheritdoc
	 * @see Iterator::current
	 *
	 * @return mixed
	 */
	public function current()
	{
		return $this->values[$this->keys[$this->position]] ?? null;
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
		return $this->keys[$this->position] ?? null;
	}

	/**
	 * @inheritdoc
	 * @see Iterator::valid
	 *
	 * @return bool
	 */
	public function valid(): bool
	{
		return isset($this->keys[$this->position]);
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
		$this->keys = array_values($this->keys);
	}
}
