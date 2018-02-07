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

	/** @var array Array access processed status */
	private $_aPrepared = [];

	/**
	 * (GET) Property mode
	 *
	 * @param string $sName
	 * @return mixed
	 */
	public function __get($sName) {
		return $this->offsetGet($sName);
	}

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
	 * @return mixed
	 */
	public function offsetGet($offset) {

		# Not exist
		if (!isset($this->_aKeys[$offset])) {
			return null;
		}

		# Detect closure or invoke | return the others
		if (isset($this->_aPrepared[$offset])
			|| !is_object($this->_aValues[$offset])
			|| !method_exists($this->_aValues[$offset], '__invoke')
		) {
			return $this->_aValues[$offset];
		}

		# Prepare
		$this->_aValues[$offset] = $this->_aValues[$offset]($this);
		$this->_aPrepared[$offset] = true;
		return $this->_aValues[$offset];

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
			unset($this->_aValues[$offset], $this->_aKeys[$offset], $this->_aPrepared[$offset]);
		}
	}

}
