<?php
namespace Coercive\App\Settings;

/**
 * Config
 *
 * @package	Coercive\App\Settings
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Config {

	# PROPERTIES LIST
	const PUBLIC_DIRECTORY = 'PUBLIC_DIRECTORY';

	/** @var array Configuration datas */
	private $_aDatas = [];

	/**
	 * SETTER : PUBLIC DIRECTORY
	 *
	 * @param string $sFullPath
	 * @return $this
	 */
	public function setPublicDirectory($sFullPath) {
		$this->_aDatas[self::PUBLIC_DIRECTORY] = (string) $sFullPath;
		return $this;
	}

	/**
	 * GETTER : PUBLIC DIRECTORY
	 *
	 * @return string
	 */
	public function getPublicDirectory() {
		return $this->_aDatas[self::PUBLIC_DIRECTORY] ?? '';
	}

}