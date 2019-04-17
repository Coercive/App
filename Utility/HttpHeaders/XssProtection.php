<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * X-XSS-Protection
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class XssProtection extends Container
{
	use TraitToString;

	const NAME = 'X-XSS-Protection';
	const DEFAULT = [
		'mode' => 'mode=block'
	];

	/** @var int */
	private $status = 1;

	/**
	 * Send header
	 *
	 * @return $this
	 */
	public function header()
	{
		if($this->getArrayCopy() && $this->status) {
			header(self::NAME . ': 1; ' . $this->toString());
		}
		else {
			header(self::NAME . ': ' . $this->status);
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
	 * Enable protection (default)
	 *
	 * @return $this
	 */
	public function enable()
	{
		$this->status = 1;
		return $this;
	}

	/**
	 * Disable protection
	 *
	 * @return $this
	 */
	public function disable()
	{
		$this->status = 0;
		return $this;
	}

	/**
	 * @param string $mode [optional]
	 * @return $this
	 */
	public function addMode(string $mode = 'block')
	{
		return $this->set('mode', "mode=$mode");
	}

	/**
	 * @param string $uri
	 * @return $this
	 */
	public function addReport(string $uri)
	{
		return $this->set('report', "report=$uri");
	}
}