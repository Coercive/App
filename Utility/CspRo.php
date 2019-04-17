<?php
namespace Coercive\App\Utility;

use Coercive\App\Service\Container;

/**
 * Content Security Policy Report Only
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy
 *
 * @package	Coercive\App\Service
 * @author	Anthony Moral <contact@coercive.fr>
 */
class CspRo extends Container
{
	const NAME = 'Content-Security-Policy-Report-Only';
}