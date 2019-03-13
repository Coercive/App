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
	 * Automatic + timestamp
	 *
	 * Example : dir/name.extension
	 *
	 * @param string $file
	 * @return string Path
	 */
	public function getPublicFilePath(string $file)
	{
		# Delete parasitics spaces / dots / slashes
		$file = str_replace(' ', '', $file);
		$file = str_replace('..', '', $file);
		$file = trim($file, '/');

		# Handle real path
		$path = realpath($this->Config->getPublicDirectory() . "/$file");

		# Verify and add timestamp
		return is_file($path) ? "/$file?" . filemtime($path) : '';
	}
}