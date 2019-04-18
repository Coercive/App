<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * X-Frame-Options
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/X-Frame-Options
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class FrameOptions extends Container
{
	use TraitToString;

	const NAME = 'X-Frame-Options';
	const DEFAULT = [
		'option' => 'SAMEORIGIN'
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
	public function addDeny()
	{
		return $this->set('option', 'DENY');
	}

	/**
	 * @return $this
	 */
	public function addSameOrigin()
	{
		return $this->set('option', 'SAMEORIGIN');
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function addAllowFrom(string $uri)
	{
		return $this->set('report', "ALLOW-FROM $uri");
	}

	/**
	 * @return $this
	 */
	public function addAllowAll()
	{
		return $this->set('option', 'ALLOWALL');
	}
}
