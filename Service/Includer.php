<?php
namespace Coercive\App\Service;

use Coercive\App\Factory\AbstractServiceAccess;

/**
 * Includer
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Includer extends AbstractServiceAccess {

	/**
	 * Automatic + timestamp
	 *
	 * Example : dir/name.extension
	 *
	 * @param string $sFile
	 * @return string Path
	 */
	public function getPublicFilePath($sFile) {

		# Delete parasitics spaces
		$sFile = str_replace(' ', '', $sFile);

		# Delete parasitics slashes
		$sFile = trim($sFile, '/');

		# Handle real path
		$sSrvPath = realpath($this->Config->getPublicDirectory() . "/$sFile");

		# Verify and add timestamp
		return is_file($sSrvPath) ? "/$sFile?" . filemtime($sSrvPath) : '';

	}

}