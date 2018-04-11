<?php
namespace Coercive\App\Service;

use ArrayAccess;

/**
 * Container
 *
 * @package	Coercive\App\Service
 * @link https://github.com/Coercive/App
 *
 * @author Anthony Moral <contact@coercive.fr>
 * @copyright 2018 Anthony Moral
 * @license MIT
 */
class Container implements ArrayAccess
{
	/** @var array Array access keys list */
	private $keys = [];

	/** @var array Array access values list */
	private $values = [];

	/** @var array Array access processed status */
	private $prepared = [];

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
		return array_key_exists($offset, $this->keys);
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
		$this->keys[$offset] = true;
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
			unset($this->values[$offset], $this->keys[$offset], $this->prepared[$offset]);
		}
	}
}
