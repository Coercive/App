<?php
namespace Coercive\App\Service;

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
	private $publicKey = '';

	/** @var string Clé privée */
	private $privateKey = '';

	/** @var bool Activate Captcha on this page */
	private $enable = false;

	/** @var float Min score threshold */
	private $threshold = null;

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
}