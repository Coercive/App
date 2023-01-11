<?php
namespace Coercive\App\Service;

/**
 * Jason helper
 *
 * This class is made only for fix this problem :
 * @link https://stackoverflow.com/questions/42981409/php7-1-json-encode-float-issue
 *
 * In the future depending on disastrous discoveries, we can add the patches to the fixlist.
 *
 * @package Coercive\App\Service
 * @author Anthony Moral <contact@coercive.fr>
 */
class Jason
{
	/** @var mixed */
	private $source;

	/** @var mixed */
	private $prepared = null;

	/**
	 * Json Flags
	 * @link https://php.net/manual/en/json.constants.php
	 * @var int
	 */
	private int $flags = 0;

	/** @var int */
	private int $decimals = 0;

	/**
	 * @param mixed $data
	 * @return mixed
	 */
	private function fix($data)
	{
		if(is_array($data)) {
			$fixed = [];
			foreach ($data as $k => $v) {
				$fixed[$k] = $this->fix($v);
			}
			return $fixed;
		}
		/**
		 * Still works in PHP version 7.1, 7.2, 7.3.4 ...
		 * @doc https://stackoverflow.com/questions/42981409/php7-1-json-encode-float-issue#answer-58595846
		 */
		if($this->hasFlags(JSON_NUMERIC_CHECK) && is_float($data)) {
			return number_format($data, $this->decimals, '.', '');
		}
		return $data;
	}

	/**
	 * @return void
	 */
	private function prepare()
	{
		if(!$this->source) {
			return;
		}

		if(!$this->flags) {
			$this->prepared = $this->source;
		}

		$this->prepared = $this->fix($this->source);
	}

	/**
	 * Jason constructor.
	 *
	 * @param mixed $data
	 * @param int|null $flags
	 * @return void
	 */
	public function __construct($data, ? int $flags = null)
	{
		$this->source = $data;
		if($flags) {
			$this->setFlags($flags);
		}
	}

	/**
	 * @param int $flags
	 * @return Jason
	 */
	public function setFlags(int $flags): Jason
	{
		$this->flags = $flags;
		return $this;
	}

	/**
	 * Check if flags given are listed in setup
	 *
	 * @doc https://stackoverflow.com/questions/11880360/how-to-implement-a-bitmask-in-php#answer-11880410
	 *
	 * @param int $flags
	 * @return bool
	 */
	public function hasFlags(int $flags): bool
	{
		return $this->flags & $flags;
	}

	/**
	 * The number of decimals used in format fonction when JSON_NUMERIC_CHECK flag is active
	 *
	 * @doc https://www.php.net/manual/en/function.number-format.php
	 *
	 * @param int $decimals
	 * @return Jason
	 */
	public function setDecimals(int $decimals): Jason
	{
		$this->decimals = $decimals;
		return $this;
	}

	/**
	 * @return string
	 */
	public function export(): string
	{
		$this->prepare();
		return json_encode($this->prepared, $this->flags);
	}
}