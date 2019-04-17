<?php
namespace Coercive\App\Utility\HttpHeaders;

/**
 * Content Security Policy Report Only
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy-Report-Only
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class CspRo extends Csp
{
	const NAME = 'Content-Security-Policy-Report-Only';
}