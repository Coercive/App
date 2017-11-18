<?php
namespace Coercive\App\Service;

use ArrayAccess;

/**
 * Container
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Container implements ArrayAccess {

	/** @var array Array access keys list */
	private $_aKeys = [];

	/** @var array Array access values list */
	private $_aValues = [];

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetExists
	 *
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset) {
		return isset($this->_aKeys[$offset]);
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetGet
	 *
	 * @param mixed $offset
	 * @return mixed|null
	 */
	public function offsetGet($offset) {
		return isset($this->_aKeys[$offset]) ? $this->_aValues[$offset] : null;
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetSet
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->_aValues[$offset] = $value;
		$this->_aKeys[$offset] = true;
	}

	/**
	 * @inheritdoc
	 * @see ArrayAccess::offsetUnset
	 *
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset) {
		if (isset($this->_aKeys[$offset])) {
			unset($this->_aValues[$offset], $this->_aKeys[$offset]);
		}
	}

}