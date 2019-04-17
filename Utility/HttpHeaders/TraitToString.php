<?php
namespace Coercive\App\Utility\HttpHeaders;

/**
 * Spit directives to string
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
trait TraitToString
{
	/**
	 * Convert directives to string
	 *
	 * @param string $escape [optional]
	 * @return string
	 */
	public function toString(string $escape = ''): string
	{
		$str = '';
		foreach ($this->getArrayCopy() as $name => $directives) {
			$str .= $name;
			if($directives) {
				$str .= ' ' . implode(' ', $directives);
			}
			$str .= '; ';
		}
		if($str && $escape) {
			$str = str_replace($escape, '', $str);
		}
		return trim($str);
	}
}