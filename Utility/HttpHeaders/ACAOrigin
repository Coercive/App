<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * Access-Control-Allow-Origin
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class ACAOrigin extends Container
{
	use TraitToString;

	const NAME = 'Access-Control-Allow-Origin';
	const DEFAULT = [
		'origin' => '*'
	];

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
	public function addAll()
	{
		return $this->set('origin', '*');
	}

	/**
	 * @return $this
	 */
	public function addNull()
	{
		return $this->set('origin', 'null');
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function addOrigin(string $uri)
	{
		return $this->set('origin', $uri);
	}
}
