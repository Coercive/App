<?php
namespace Coercive\App\Core;

use Pimple\Container;
use Apfelbox\FileDownload\FileDownload;

use DateTime;
use DateTimeZone;

abstract class AbstractApp extends Container {

	/**
	 *
	 * @todo on a vraiment besoin de Pimple ?
	 * @todo faire un Service handler plutôt qu'une class array access ?
	 *
	 */

	/**
	 * GET SERVICE
	 *
	 * @param string $sName
	 * @return object
	 */
	public function __get($sName) {

		/**
		 *
		 * @todo utiliser un objet Service à la place de cette merde
		 *
		 */

		# PROPERTY
		if(isset($this->{$sName})) { return $this->{$sName}; }

		# SKIP ERROR
		if(!isset($this[$sName])) {
			throw new \InvalidArgumentException('Service not found : ' . $sName);
		}

		return $this[$sName];

	}

	/**
	 * Automatic + timestamp
	 *
	 * Example : dir/name.extension
	 *
	 * @param string $sFile
	 * @return string Path
	 */
	public function includePublicFile($sFile) {

		/**
		 *
		 * @todo faire un service d'inclusion de fichier public
		 *
		 */

		$sFile = str_replace(' ', '', $sFile);
		$sFile = trim($sFile, '/');
		$sSrvPath = realpath(SRV_BASEPATH . "/web/$sFile");
		return file_exists($sSrvPath) ? "/$sFile?" . filemtime($sSrvPath) : '';
	}

	/**
	 * Lance le téléchargement d'un fichier
	 *
	 * @param string $sPath ex : /dossier/prod/file/monfichier.pdf
	 * @param string $sName ex : revue101.pdf
	 * @return void
	 */
	public function downloadFile($sPath, $sName) {

		/**
		 *
		 * @todo ça sert à rien de faire une méthode relai pour juste une ligne -> à virer
		 *
		 */

		FileDownload::createFromFilePath($sPath)->sendDownload($sName);
	}

	/**
	 * Lance le téléchargement d'un fichier
	 *
	 * @param string $sString : contenu du fichier
	 * @param string $sName ex : revue101.pdf
	 * @return void
	 */
	public function downloadString($sString, $sName) {

		/**
		 *
		 * @todo ça sert à rien de faire une méthode relai pour juste une ligne -> à virer
		 *
		 */

		FileDownload::createFromString($sString)->sendDownload($sName);
	}

	/**
	 * SET LOCALE
	 */
	protected function setLocale() {

		/**
		 *
		 * @todo faire un service de gestion de locale (voir si ça existe déjà ?)
		 *
		 */

		# Skip
		if (!defined('LANGUAGE')) { return; }

		# Locales possibles à trouver
		$aLocale = [
			'FR' => [
				'fr', 'FR', 'fr_FR', 'fr_FR.utf8', 'fr_FR.utf-8', 'fra'
			],
			'EN' => [
				'en', 'EN', 'en_EN', 'en_EN.utf8', 'en_EN.utf-8', 'eng'
			]
		];

		# setLocale()
		call_user_func_array('setlocale', array_merge([LC_ALL], $aLocale[LANGUAGE]));
	}

	/**
	 * TIME ZONE SERVER
	 *
	 * @return DateTimeZone
	 */
	public function serverTimeZone() {

		/**
		 *
		 * @todo faire un service de gestion de locale (voir si ça existe déjà ?)
		 *
		 */

		return new DateTimeZone(ini_get('date.timezone'));
	}

	/**
	 * ALIAS PHP strftime()
	 *
	 * @param string $sPattern
	 * @param string $sSqlDate
	 * @return string
	 */
	public function strftime($sSqlDate, $sPattern = "%A %d %B %Y %H:%M:%S") {

		/**
		 *
		 * @todo faire un service de gestion de locale (voir si ça existe déjà ?)
		 *
		 */

		return strftime($sPattern, (new DateTime($sSqlDate, $this->serverTimeZone()))->getTimestamp());
	}

	/**
	 * DECALAGE FUSEAU HORAIRE SCRIPT/SERVER
	 *
	 * Différent : TRUE
	 * Identique : FALSE
	 *
	 * @return int
	 */
	public function isJetLagScriptDiffers() {

		/**
		 *
		 * @todo faire un service de gestion de locale (voir si ça existe déjà ?)
		 *
		 */

		return strcmp(date_default_timezone_get(), ini_get('date.timezone'));
	}

}