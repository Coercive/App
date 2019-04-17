<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * Referrer-Policy
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Referrer-Policy
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Rp extends Container
{
	use TraitToString;

	const NAME = 'Referrer-Policy';
	const META_NAME = 'referrer';
	const DEFAULT = [
		'no-referrer-when-downgrade' => []
	];

	/**
	 * Send header
	 *
	 * @return $this
	 */
	public function header()
	{
		if($this->getArrayCopy()) {
			header(static::NAME . ': ' . $this->toString());
		}
		return $this;
	}

	/**
	 * Send to meta
	 *
	 * @return string
	 */
	public function meta(): string
	{
		return $this->getArrayCopy() ? '<meta name="referrer" content="'. $this->toString('"') .'">' : '';
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
	public function addNoReferrer()
	{
		return $this->set('no-referrer', []);
	}

	/**
	 * @return $this
	 */
	public function addNoReferrerWhenDowngrade()
	{
		return $this->set('no-referrer-when-downgrade', []);
	}

	/**
	 * @return $this
	 */
	public function addOrigin()
	{
		return $this->set('origin', []);
	}

	/**
	 * @return $this
	 */
	public function addOriginWhenCrossOrigin()
	{
		return $this->set('origin-when-cross-origin', []);
	}

	/**
	 * @return $this
	 */
	public function addSameOrigin()
	{
		return $this->set('same-origin', []);
	}

	/**
	 * @return $this
	 */
	public function addStrictOrigin()
	{
		return $this->set('strict-origin', []);
	}

	/**
	 * @return $this
	 */
	public function addStrictOriginWhenCrossOrigin()
	{
		return $this->set('strict-origin-when-cross-origin', []);
	}

	/**
	 * @return $this
	 */
	public function addUnsafeUrl()
	{
		return $this->set('unsafe-url', []);
	}
}