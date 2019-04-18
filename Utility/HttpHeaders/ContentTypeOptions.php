<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * X-Content-Type-Options
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/X-Content-Type-Options
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class ContentTypeOptions extends Container
{
	use TraitToString;

	const NAME = 'X-Content-Type-Options';
	const DEFAULT = [
		'option' => 'nosniff'
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
	 * @return $this
	 */
	public function addNoSniff()
	{
		return $this->set('option', 'nosniff');
	}
}
