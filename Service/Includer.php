<?php
namespace Coercive\App\Service;

use Coercive\App\Factory\AbstractServiceAccess;

/**
 * Includer
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Includer extends AbstractServiceAccess
{
	/**
	 * Clean this path str
	 * Delete parasitics spaces / dots / slashes
	 *
	 * @param string $str
	 * @return string
	 */
	private function clean(string $str): string
	{
		$str = str_replace(' ', '', $str);
		$str = str_replace('..', '', $str);
		$str = trim($str, '/');
		return $str;
	}

	/**
	 * Create a sub resource integrity hash
	 *
	 * @param string $str
	 * @return string
	 */
	private function sri(string $str): string
	{
		return 'sha512-' . base64_encode(hash('sha512', $str, true));
	}

	/**
	 * Automatic + timestamp
	 *
	 * Example : dir/name.extension
	 *
	 * @param string $file
	 * @return string Path
	 */
	public function getPublicFilePath(string $file): string
	{
		# Clean
		$file = $this->clean($file);

		# Handle real path
		$path = realpath($this->Config->getPublicDirectory() . "/$file");

		# Verify and add timestamp
		return is_file($path) ? "/$file?" . filemtime($path) : '';
	}

	/**
	 * SRI for file
	 *
	 * @param string $file
	 * @return string
	 */
	public function getPublicFileSri(string $file): string
	{
		# Clean
		$file = $this->clean($file);

		# Handle real path
		$path = realpath($this->Config->getPublicDirectory() . "/$file");
		$content = (string) @file_get_contents($path);

		# Subresource integrity hash
		return $this->sri($content);
	}

	/**
	 * SRI for input content
	 *
	 * @param string $script
	 * @return string
	 */
	public function getPublicInlineSri(string $script): string
	{
		return $this->sri($script);
	}
}