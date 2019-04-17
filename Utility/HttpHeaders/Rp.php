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
	const NAME = 'Referrer-Policy';
	const META_NAME = 'referrer';
	const DEFAULT = 'no-referrer-when-downgrade';

	/**
	 * Send header
	 *
	 * @return $this
	 */
	public function header()
	{
		if($this->getArrayCopy()) {
			header(self::NAME . ': ' . $this->get(self::NAME));
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
		return $this->get(self::NAME) ? '<meta name="referrer" content="'. $this->get(self::NAME) .'">' : '';
	}

	/**
	 * Set default parameters
	 *
	 * @return $this
	 */
	public function setDefault()
	{
		return $this->set(self::NAME, self::DEFAULT);
	}

	/**
	 * @return $this
	 */
	public function addNoReferrer()
	{
		return $this->set(self::NAME, 'no-referrer');
	}

	/**
	 * @return $this
	 */
	public function addNoReferrerWhenDowngrade()
	{
		return $this->set(self::NAME, 'no-referrer-when-downgrade');
	}

	/**
	 * @return $this
	 */
	public function addOrigin()
	{
		return $this->set(self::NAME, 'origin');
	}

	/**
	 * @return $this
	 */
	public function addOriginWhenCrossOrigin()
	{
		return $this->set(self::NAME, 'origin-when-cross-origin');
	}

	/**
	 * @return $this
	 */
	public function addSameOrigin()
	{
		return $this->set(self::NAME, 'same-origin');
	}

	/**
	 * @return $this
	 */
	public function addStrictOrigin()
	{
		return $this->set(self::NAME, 'strict-origin');
	}

	/**
	 * @return $this
	 */
	public function addStrictOriginWhenCrossOrigin()
	{
		return $this->set(self::NAME, 'strict-origin-when-cross-origin');
	}

	/**
	 * @return $this
	 */
	public function addUnsafeUrl()
	{
		return $this->set(self::NAME, 'unsafe-url');
	}
}