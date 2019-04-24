<?php
namespace Coercive\App\Service;

/**
 * Capture
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Capture
{
	/** @var string[] */
	private $buffered = [];

	/**
	 * Start capture buffer
	 *
	 * @return Capture
	 */
	public function start(): Capture
	{
		ob_start();
		return $this;
	}

	/**
	 * End capture buffer
	 *
	 * @param string $namespace [optional]
	 * @return Capture
	 */
	public function end(string $namespace = 'default'): Capture
	{
		$this->buffered[$namespace] = ($this->buffered[$namespace] ?? '') . ob_get_clean();
		return $this;
	}

	/**
	 * Retrieve captured buffer
	 *
	 * @param string $namespace [optional]
	 * @return string
	 */
	public function get(string $namespace = 'default'): string
	{
		return $this->buffered[$namespace] ?? '';
	}
}