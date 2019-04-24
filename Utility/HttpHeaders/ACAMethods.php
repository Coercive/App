<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * Access-Control-Allow-Methods
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class ACAMethods extends Container
{
	const NAME = 'Access-Control-Allow-Methods';
	const DEFAULT = [
		'method' => [
			'GET',
			'HEAD',
			'POST',
			'OPTIONS',
		]
	];

	/**
	 * @return string
	 */
	private function toString(): string
	{
		return implode(', ', $this->get('method') ?: []);
	}

	/**
	 * Send header
	 *
	 * @return $this
	 */
	public function header()
	{
		if($this->getArrayCopy()) {
			header(self::NAME . ': ' . $this->toString());
		}
		return $this;
	}

	/**
	 * Set default parameters
	 *
	 * @return $this
	 */
	public function setDefault()
	{
		return $this->from(self::DEFAULT);
	}

	/**
	 * @return $this
	 */
	public function addGet()
	{
		return $this->push('method', 'GET');
	}

	/**
	 * @return $this
	 */
	public function addHead()
	{
		return $this->push('method', 'HEAD');
	}

	/**
	 * @return $this
	 */
	public function addPost()
	{
		return $this->push('method', 'POST');
	}

	/**
	 * @return $this
	 */
	public function addPut()
	{
		return $this->push('method', 'PUT');
	}

	/**
	 * @return $this
	 */
	public function addDelete()
	{
		return $this->push('method', 'DELETE');
	}

	/**
	 * @return $this
	 */
	public function addConnect()
	{
		return $this->push('method', 'CONNECT');
	}

	/**
	 * @return $this
	 */
	public function addOptions()
	{
		return $this->push('method', 'OPTIONS');
	}

	/**
	 * @return $this
	 */
	public function addTrace()
	{
		return $this->push('method', 'TRACE');
	}

	/**
	 * @return $this
	 */
	public function addPatch()
	{
		return $this->push('method', 'PATCH');
	}
}
