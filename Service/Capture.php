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
	private array $buffered = [];

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
	 * @param bool $new [optional]
	 * @return Capture
	 */
	public function end(string $namespace = 'default', bool $new = true): Capture
	{
		$this->buffered[$namespace] = ($new ? '' : $this->buffered[$namespace] ?? '') . ob_get_clean();
		return $this;
	}

	/**
	 * Retrieve captured buffer
	 *
	 * @param string $namespace [optional]
	 * @param bool $clear [optional]
	 * @return string
	 */
	public function get(string $namespace = 'default', bool $clear = false): string
	{
		if($clear) {
			$this->clear($namespace);
		}
		return $this->buffered[$namespace] ?? '';
	}

	/**
	 * Clear captured buffer
	 *
	 * @param string $namespace [optional]
	 * @return Capture
	 */
	public function clear(string $namespace = 'default'): Capture
	{
		unset($this->buffered[$namespace]);
		return $this;
	}
}