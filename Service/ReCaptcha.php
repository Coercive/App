<?php
namespace Coercive\App\Service;

use Closure;
use Exception;

/**
 * ReCaptcha V2 / V3
 *
 * @link https://developers.google.com/recaptcha
 * @documentation V2 https://developers.google.com/recaptcha/docs/display
 * @documentation V3 https://developers.google.com/recaptcha/docs/v3
 *
 * @package Coercive\App\Service
 * @author Anthony Moral <contact@coercive.fr>
 */
class ReCaptcha
{
	/** @const string Url pour la validation */
	const URL = 'https://www.google.com/recaptcha/api/siteverify?';

	/** @var string Clé publique */
	private string $publicKey = '';

	/** @var string Clé privée */
	private string $privateKey = '';

	/** @var bool Activate Captcha on this page */
	private bool $enable = false;

	/** @var float|null Min score threshold */
	private ? float $threshold = null;

	/** @var Closure|null Callback function to store current result of reCaptcha */
	private ? Closure $storeCallback = null;

	/** @var Closure|null Callback function to retrieve result of reCaptcha */
	private ? Closure $retrieveCallback = null;

	/**
	 * Callback function to store current result of reCaptcha.
	 *
	 * Callback takes a boolean param in first argument that is the result of the reCaptcha validate method.
	 *
	 * @param Closure $callback
	 * @return $this
	 */
	public function setStoreCallback(Closure $callback): self
	{
		$this->storeCallback = $callback;
		return $this;
	}

	/**
	 * Callback function to retrieve result of reCaptcha.
	 *
	 * Callback returns null if data can't be retrieved.
	 *
	 * @param Closure $callback
	 * @return void
	 */
	public function setRetrieveCallback(Closure $callback): void
	{
		$this->retrieveCallback = $callback;
	}

	/**
	 * Min score threshold, under it's a bot
	 *
	 * @param float $threshold [optional]
	 * @return $this
	 * @throws Exception
	 */
	public function threshold(float $threshold = 0.5): ReCaptcha
	{
		if($threshold < 0 || $threshold > 1) {
			throw new Exception('Recaptcha threshold must be between 0 and 1');
		}
		$this->threshold = $threshold;
		return $this;
	}

	/**
	 * Enable captcha on this page
	 *
	 * @return $this
	 */
	public function enable(): ReCaptcha
	{
		$this->enable = true;
		return $this;
	}

	/**
	 * Disable captcha on this page
	 *
	 * @return $this
	 */
	public function disable(): ReCaptcha
	{
		$this->enable = false;
		return $this;
	}

	/**
	 * Verify activation status
	 *
	 * @return bool
	 */
	public function isEnable(): bool
	{
		return $this->enable;
	}

	/**
	 * [SET] Public key
	 *
	 * @param string $key
	 * @return $this
	 */
	public function setPublicKey(string $key): ReCaptcha
	{
		$this->publicKey = $key;
		return $this;
	}

	/**
	 * [SET] Private key
	 *
	 * @param string $key
	 * @return $this
	 */
	public function setPrivateKey(string $key): ReCaptcha
	{
		$this->privateKey = $key;
		return $this;
	}

	/**
	 * Public key
	 *
	 * @return string
	 */
	public function getPublicKey(): string
	{
		return $this->publicKey;
	}

	/**
	 * Validate token
	 *
	 * @param string $token
	 * @return bool
	 */
	public function validate(string $token): bool
	{
		# Skip on error
		if(!$token || !$this->publicKey || !$this->privateKey) {
			return false;
		}

		# Build captcha url
		$url = self::URL . http_build_query([
			'secret' => $this->privateKey,
			'response' => $token
		]);

		# Request
		$response = (string) @file_get_contents($url);
		if(!$response) {
			return false;
		}

		# Handle result
		try {
			$json = json_decode($response);
			if (json_last_error() === JSON_ERROR_NONE) {

				# V2 : only success on customer test
				$success = boolval($json->success ?? false);
				if(null === $this->threshold) {
					return $success;
				}

				# V3 : interpreting the score
				$score = floatval($json->score ?? false);
				return $success && $score > $this->threshold;
			}
			return false;
		}
		catch(Exception $e) {
			return false;
		}
	}

	/**
	 * Validates the reCaptcha using validate(), but with data persistence.
	 *
	 * @param string $token
	 * @return bool
	 */
	public function validateAndPersist(string $token): bool
	{
		if (null !== $this->retrieveCallback) {
			if(null !== $result = ($this->retrieveCallback)()) {
				return (bool) $result;
			}
		}

		$result = $this->validate($token);

		if (null !== $this->storeCallback) {
			($this->storeCallback)($result);
		}

		return $result;
	}
}