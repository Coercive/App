<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * HTTP Strict Transport Security
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Hsts extends Container
{
	use TraitToString;

	const NAME = 'Strict-Transport-Security';
	const DEFAULT = [
		'max-age' => 'max-age=31536000',
		'includeSubDomains' => 'includeSubDomains',
		'preload' => 'preload'
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
	 * @param int $age [optional]
	 * @return $this
	 */
	public function addMaxAge(int $age = 31536000)
	{
		return $this->set('max-age', "max-age=$age");
	}

	/**
	 * @return $this
	 */
	public function addIncludeSubDomains()
	{
		return $this->set('includeSubDomains', 'includeSubDomains');
	}

	/**
	 * @return $this
	 */
	public function addPreload()
	{
		return $this->set('preload', 'preload');
	}
}