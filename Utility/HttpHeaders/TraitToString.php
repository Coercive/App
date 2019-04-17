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
	 * @param bool $keys [optional]
	 * @param string $escape [optional]
	 * @return string
	 */
	public function toString(bool $keys = false, string $escape = ''): string
	{
		$str = '';
		foreach ($this->getArrayCopy() as $name => $directives) {
			if($keys && !is_numeric($name)) {
				$str .= $name;
			}
			if($directives) {
				$str .= ' ' . (is_array($directives) ? implode(' ', $directives) : $directives);
			}
			$str .= '; ';
		}
		if($str && $escape) {
			$str = str_replace($escape, '', $str);
		}
		return trim($str, ' ,;');
	}
}