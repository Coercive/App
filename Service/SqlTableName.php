<?php
namespace Coercive\App\Service;

use Exception;

/**
 * Helper Sql Table Name
 *
 * @package	Coercive\App\Service
 * @author Anthony Moral <contact@coercive.fr>
 */
class SqlTableName
{
	private string $env = '';

	private array $prefixes = [];

	private array $suffixes = [];

	private string $database = '';

	private string $table = '';

	private string $alias = '';

	private bool $backtick = true;

	/**
	 * Add backticks arround table name
	 *
	 * @param string $name
	 * @return string
	 * @throws Exception
	 */
	private function protect(string $name): string
	{
		# Dangerous chars for fields or table / db name
		if(!preg_match('`^[a-z\d\.-_]+$`i', $name)) {
			throw new Exception('Illegal characters in the database name or table name');
		}
		return '`' . str_replace('.', '`.`', $name) . '`';
	}

	/**
	 * SqlTableName constructor.
	 *
	 * @param string $env [optional]
	 * @param array $prefixes [optional]
	 * @param array $suffixes [optional]
	 * @param bool $backtick [optional]
	 */
	public function __construct(string $env = '', array $prefixes = [], array $suffixes = [], bool $backtick = true)
	{
		$this->env($env);
		$this->prefixes($prefixes);
		$this->suffixes($suffixes);
		$this->backtick($backtick);
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function __toString(): string
	{
		return $this->get();
	}

	/**
	 * @param bool|null $backtick [optional]
	 * @return string
	 * @throws Exception
	 */
	public function get(? bool $backtick = null): string
	{
		if(!$this->table) {
			return '';
		}


		$t = $this->table;
		$prefix = $this->prefixes[$this->env] ?? '';
		$suffix = $this->suffixes[$this->env] ?? '';
		$alias = ($this->alias ? ' as ' . $this->alias : '');
		$d = $this->database ? $prefix . $this->database . $suffix : '';
		$this->reset();

		$name =  ($d ? $d . '.' : '') . $t;
		if($this->backtick && null === $backtick || $backtick) {
			return $this->protect($name) . $alias;
		}
		return $name . $alias;
	}

	/**
	 * @return $this
	 */
	public function reset(): self
	{
		$this->database = '';
		$this->table = '';
		$this->alias = '';
		return $this;
	}

	/**
	 * @param string $env
	 * @return $this
	 */
	public function env(string $env): self
	{
		$this->env = $env;
		return $this;
	}

	/**
	 * @param array $prefixes
	 * @return $this
	 */
	public function prefixes(array $prefixes): self
	{
		$this->prefixes = $prefixes;
		return $this;
	}

	/**
	 * @param array $suffixes
	 * @return $this
	 */
	public function suffixes(array $suffixes): self
	{
		$this->suffixes = $suffixes;
		return $this;
	}

	/**
	 * @param bool $enable [optional]
	 * @return $this
	 */
	public function backtick(bool $enable = true): self
	{
		$this->backtick = $enable;
		return $this;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function database(string $name): self
	{
		$this->database = $name;
		return $this;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function table(string $name): self
	{
		$this->table = $name;
		return $this;
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function alias(string $name): self
	{
		$this->alias = $name;
		return $this;
	}
}