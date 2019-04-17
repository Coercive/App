<?php
namespace Coercive\App\Utility\HttpHeaders;

use Coercive\App\Service\Container;

/**
 * Content Security Policy
 *
 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy
 *
 * @package	Coercive\App\Utility
 * @author	Anthony Moral <contact@coercive.fr>
 */
class Csp extends Container
{
	use TraitToString;

	const NAME = 'Content-Security-Policy';

	/**
	 * By default we use https only and self relations
	 */
	const DEFAULT = [
		'default-src' => ['https:', "'self'"],
		'block-all-mixed-content' => []
	];

	/**
	 * Send CSP header
	 *
	 * @return $this
	 */
	public function header()
	{
		if($this->getArrayCopy()) {
			header(static::NAME . ': ' . $this->toString(true));
		}
		return $this;
	}

	/**
	 * Send CSP to meta
	 *
	 * @return string
	 */
	public function meta(): string
	{
		return $this->getArrayCopy() ? '<meta http-equiv="'. static::NAME .'" content="'. $this->toString(true, '"') .'">' : '';
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
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/child-src
	 * @param string $source
	 * @return $this
	 */
	public function addChildSrc(string $source)
	{
		return $this->push('child-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/connect-src
	 * @param string $source
	 * @return $this
	 */
	public function addConnectSrc(string $source)
	{
		return $this->push('connect-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/default-src
	 * @param string $source
	 * @return $this
	 */
	public function addDefaultSrc(string $source)
	{
		return $this->push('default-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/font-src
	 * @param string $source
	 * @return $this
	 */
	public function addFontSrc(string $source)
	{
		return $this->push('font-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/frame-src
	 * @param string $source
	 * @return $this
	 */
	public function addFrameSrc(string $source)
	{
		return $this->push('frame-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/img-src
	 * @param string $source
	 * @return $this
	 */
	public function addImgSrc(string $source)
	{
		return $this->push('img-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/manifest-src
	 * @param string $source
	 * @return $this
	 */
	public function addManifestSrc(string $source)
	{
		return $this->push('manifest-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/media-src
	 * @param string $source
	 * @return $this
	 */
	public function addMediaSrc(string $source)
	{
		return $this->push('media-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/object-src
	 * @param string $source
	 * @return $this
	 */
	public function addObjectSrc(string $source)
	{
		return $this->push('object-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/script-src
	 * @param string $source
	 * @return $this
	 */
	public function addScriptSrc(string $source)
	{
		return $this->push('script-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/style-src
	 * @param string $source
	 * @return $this
	 */
	public function addStyleSrc(string $source)
	{
		return $this->push('style-src', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/worker-src
	 * @param string $source
	 * @return $this
	 */
	public function addWorkerSrc(string $source)
	{
		return $this->push('worker-src', $source);
	}

	/**
	 * @deprecated
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/report-uri
	 * @param string $uri
	 * @return $this
	 */
	public function addReportUri(string $uri)
	{
		return $this->push('report-uri', $uri);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/report-to
	 * @param string $json
	 * @return $this
	 */
	public function addReportTo(string $json)
	{
		return $this->push('report-to', $json);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/base-uri
	 * @param string $uri
	 * @return $this
	 */
	public function addBaseUri(string $uri)
	{
		return $this->push('base-uri', $uri);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/plugin-types
	 * @param string $type
	 * @return $this
	 */
	public function addPluginTypes(string $type)
	{
		return $this->push('plugin-types', $type);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox
	 * @param string $allow
	 * @return $this
	 */
	public function addSandbox(string $allow)
	{
		return $this->push('sandbox', $allow);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/form-action
	 * @param string $source
	 * @return $this
	 */
	public function addFormAction(string $source)
	{
		return $this->push('form-action', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/frame-ancestors
	 * @param string $source
	 * @return $this
	 */
	public function addFrameAncestors(string $source)
	{
		return $this->push('frame-ancestors', $source);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/block-all-mixed-content
	 * @return $this
	 */
	public function addBlockAllMixedContent()
	{
		return $this->set('block-all-mixed-content', []);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/require-sri-for
	 * @param string $resource
	 * @return $this
	 */
	public function addRequireSriFor(string $resource)
	{
		return $this->push('require-sri-for', $resource);
	}

	/**
	 * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Security-Policy/upgrade-insecure-requests
	 * @return $this
	 */
	public function addUpgradeInsecureRequests()
	{
		return $this->set('upgrade-insecure-requests', []);
	}
}