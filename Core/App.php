<?php
namespace Coercive\App\Core;

/**
 *
 * @todo Virer toutes les dépendences inutiles
 * @todo Ajouter une méthode addService public (avec objet service)
 * @todo Tout doit être généralisé, les trucs spécifiques sont à déclarer dans le projet
 * @todo une interface avec des méthodes genre "boot" à déclarer lors de l'extends
 *
 */

# Coercive
use Coercive\Security\Cookie\Cookie;
use Coercive\Security\Token\Token;
use Coercive\Utility\Render\Render;
use Coercive\Utility\Router\Loader;
use Coercive\Utility\Router\Router;
use Coercive\Utility\Slugify\Slugify;
use Coercive\Security\Xss\XssUrl;
use Coercive\Utility\Cache\Redis;

# Security
use App\Security\Browser\Browser;
use App\Security\IpBlock\IpBlock;
use App\Security\Maintenance\Maintenance;
use App\Security\Purge\Purge;

# Utility
use App\Utility\Email\EmailMonitoring;
use App\Utility\Translate\Translate;
use App\Utility\ImageProcess\ImageEngine;

# Project Class
use Project\Db\Db;
use Project\Controller\Error;
use Project\Email\Email;
use Project\Factory\ControllerFactory;
use Project\Factory\ModelFactory;
use Project\Factory\MiscFactory;
use Project\Session\Session;

# Espace PHP
use ReflectionMethod;
use ErrorException;
use Exception;

/**
 * Class App
 *
 * Unus pro omnibus, omnes pro uno, nos autem fortes, nos unum sumus.
 *
 * @package App\Core
 * @use		Pimple Container v3
 *
 * @author  Anthony <contact@anthonymoral.fr>
 *
 * @property App $app
 * @property \Aouka\DB\AbstractDb $DB
 * @property Translate $Translate
 * @property Purge $Purge
 * @property Slugify $Slugify
 * @property ImageEngine $ImageEngine
 * @property Error $Error
 * @property Browser $Browser
 * @property Token $Token
 * @property XssUrl $XssUrl
 * @property Session $Session
 * @property Render $Render
 * @property Redis $Redis
 * @property Email $Email
 * @property EmailMonitoring $EmailMonitoring
 * @property ControllerFactory $Controller
 * @property ModelFactory $Model
 * @property MiscFactory $Misc
 */
class App extends AbstractApp {

	/** @var App $oApp */
	static private $oApp = null;

	/** @var Redis */
	public $Redis = null;

	/** @var Router */
	public $Router;

	/**
	 * External Mini APP
	 *
	 * @param array $aOptions [optional]
	 * @return App
	 */
	static public function getApp($aOptions = []) {

		# SINGLETON
		if(self::$oApp) { return self::$oApp; }

		# Bloquer le constructeur
		self::$oApp = true;

		/** @var App $oApp */
		$oApp = new self;

		# OPTIONS
		$aOptions = array_replace_recursive([
			'CONST' => [],
			'DB'    => Db::get()
		], $aOptions);

		# DEFINE
		foreach($aOptions['CONST'] as $sConstName => $sConstValue) {
			if(!defined($sConstName)) { define($sConstName, $sConstValue); }
		}

		# Chargement du Router
		$oApp->_initRouter();

		# LOAD SERVICES
		$oApp->_addServices($oApp);

		# OVERWRITE DEFAULT SERVICES
		$oApp->DB = $aOptions['DB'];

		# SET
		return self::$oApp = $oApp;
	}

	/**
	 * Prépare les variables de dossier, de fichier, de classe
	 */
	public function __construct() {

		/** @see \Pimple\Container */
		parent::__construct();

		# Skip Static Construct
		if(self::$oApp) { return; }

		/**
		 *
		 * @todo ça ok c'est important
		 *
		 */

		# Toutes les erreurs sont transformées en exceptions
		$this->_errorToException();

		/**
		 *
		 * @todo pourquoi pas, peut-on améliorer ?
		 *
		 */

		# Init Cache
		$this->_initCache();

		/**
		 *
		 * @todo ok obligatoire
		 *
		 */

		# Chargement du Router
		$this->_initRouter();

		/**
		 *
		 * @todo faire une classe Language pour gérer ça (à injecter en tant que service)
		 * @todo et laisser une méthode libre pour l'intégration dans l'App et la gestion par projet
		 *
		 */

		# Gestion de la langue
		$this->_manageLanguage();

		/**
		 *
		 * @todo à revoir
		 * @todo une méthode publique
		 * @todo et une class qui gère l'intégration des services
		 *
		 */

		# Chargement de Services
		$this->_addServices($this);

		/**
		 *
		 * @todo l'initialisation se fera par l'ordre reçu en add service
		 * @todo et on aura un objet Service avec des informations "register" et "boot" pour initialiser avant le lancement général
		 *
		 */

		# Initialisation de Services
		$this->_initServices();

		/**
		 *
		 * @todo ça fait partie des services
		 *
		 */

		# Détection XSS
		$this->_xssWall();

		/**
		 *
		 * @todo C'est relié à la BDD du projet, mais sans doute qu'on peut l'injecter en tant que service, à voir.
		 * @todo Peut-être faire un processus de compilation avant démarage de l'app (register) ?
		 *
		 */

		# Blocage IP
		new IpBlock($this);

		/**
		 *
		 * @todo idem, mais une méthode séparer à redéfinir c'est pas mal
		 *
		 */

		# Gestion Online / Offline
		$this->_maintenance();

		/**
		 *
		 * @todo trouver des idées pour ça
		 *
		 */

		# Gestion Redirections
		$this->_redirectLinkManagement();

		/**
		 *
		 * @todo Utiliser autant que possible l'objet loader du Router
		 * @todo il faudra peut-être l'améliorer vu qu'il n'a pas été utilisé encore ...
		 *
		 */

		# Chargement Controller
		$this->_loadController();

	}

	/**
	 * INIT CACHE
	 *
	 * @throws Exception
	 */
	private function _initCache() {

		# Load Redis
		$this->Redis = new Redis(PROJECT_CODE.'_'.ENV);
		if(!$this->Redis->isConnected()) {
			throw new Exception("Can't start Redis");
		}

		# Set Default Delay for ESPRIT
		$this->Redis->setExpireDelay('P7D');

	}

	/**
	 * INIT ROUTER YAML / CACHE
	 */
	private function _initRouter() {

		# REDIS
		try {

			# ROUTER BY CACHE
			$mRoutes = $this->Redis->get('router.routes');
			if($mRoutes && !$this->Redis->isError()) {
				$this->Router = Loader::loadByCache($mRoutes);
			}

			# ROUTER BY FILE (and set cache)
			else {
				$this->Router = Loader::loadByYaml([SRV_BASEPATH.'/src/Project/Routes/routes.yml']);
				$this->Redis->set('router.routes', $this->Router->getPreparedRoutesForCache());
			}

		}

		# BACKUP
		catch(Exception $oException) {

			error_log(print_r('ESPRIT PRESSE ' . ENV, true));
			error_log(print_r('WARNING REDIS : can\'t load. Router basic start with yaml.', true));
			error_log(print_r($oException->getMessage(), true));
			error_log(print_r($oException->getTraceAsString(), true));

			$this->Router = Loader::loadByYaml([[SRV_BASEPATH.'/src/Project/Routes/routes.yml']]);

		}

	}

	/**
	 * XSS detect
	 *
	 * @return void
	 */
	private function _xssWall() {

		# Detect
		$this->XssUrl->setUrl($this->Router->getRawCurrentURL(true));
		if(!$this->XssUrl->isXss()) { return; }

		# CRASH
		exit;

	}

	/**
	 * MAINTENANCE :: Hors Ligne +=> DIE
	 *
	 * @return void
	 */
	private function _maintenance() {
		/** @var array|bool $mContent */
		if ($mContent = (new Maintenance($this))->offline()) {

			# Préparation du message d'erreur
			$aData['sTitle'] = empty($mContent['sTitle']) ? false : $mContent['sTitle'];
			$aData['sMessage'] = empty($mContent['sMessage']) ? false : $mContent['sMessage'];

			# Affichage
			echo $this->Render
				->setPath('/none/error/maintenance')
				->setGlobalDatas(['app' => $this])
				->setDatas($aData)
				->render();

			# END
			exit;
		}
	}

	/**
	 * Ajoute des Services(Controller, Model, Divers) à App
	 *
	 * @param App $oApp
	 */
	private function _addServices($oApp) {

		# STATIC ---------
		$this['DB'] = function () { return Db::get(); };
		$this['Translate'] = function () use ($oApp) { return Translate::getInstance($oApp); };
		# STATIC ---------

		# SHORTCUT ---------
		$this['XssUrl'] = function () { return new XssUrl; };
		$this['Purge'] = function () { return new Purge(['127.0.0.1', '178.33.45.144']); };
		$this['Token'] = function () { return new Token; };
		$this['Browser'] = function () { return new Browser; };
		$this['Slugify'] = function () { return new Slugify; };
		$this['ImageEngine'] = function () use ($oApp) { return new ImageEngine($oApp); };
		$this['Session'] = function () use ($oApp) { return new Session($oApp); };
		$this['Error'] = function () use ($oApp) { return new Error($oApp); };
		$this['Render'] = function () { return new Render(SRV_BASEPATH . '/view/'); };
		$this['Email'] = function () use ($oApp) { return new Email($oApp); };
		$this['EmailMonitoring'] = function () use ($oApp) { return new EmailMonitoring($oApp); };
		# SHORTCUT ---------

		# FACTORY ---------
		$this['Controller'] = function () use ($oApp) { return new ControllerFactory($oApp); };
		$this['Model'] = function () use ($oApp) { return new ModelFactory($oApp); };
		$this['Misc'] = function () use ($oApp) { return new MiscFactory($oApp); };
		# FACTORY ---------

	}

	/**
	 * Initialise certains services
	 */
	private function _initServices() {

		$this->Translate;
		$this->Session;

	}

	/**
	 * Gestion de la langue FR - EN
	 *
	 * @return void
	 */
	private function _manageLanguage() {
		# Route Lang
		$sLang = $this->Router->getLang();
		$bValidURL = $this->Router->getId() && !in_array($this->Router->getId(), ['HOME', 'NATIXIS_AUTO_RESPONSE'], true);

		# Langue enregistrée
		$sLangCookie = (string) Cookie::getSafe('language');

		# Langue via route
		if ($bValidURL && $sLang && $sLangCookie !== $sLang) {
			Cookie::setSafe('language', $sLang, time() + 3600);
			$sLangCookie = $sLang;
		}

		# Set
		if (!$sLangCookie || ($sLangCookie !== 'FR' && $sLangCookie !== 'EN')) {
			# Langue par défaut du site
			Cookie::setSafe('language', 'FR', time() + 3600);
			if (!defined('LANGUAGE')) { define('LANGUAGE', 'FR'); }
		} else {
			# Sinon, langue demandée
			if (!defined('LANGUAGE')) { define('LANGUAGE', $sLangCookie); }
		}

		# Php Locale
		$this->setLocale();
	}

	/**
	 * Supprime les redirections inutiles
	 *
	 * Réinitialise les éventuelles redirections
	 * Sauf si l'utilisateur est en cours de connection (formulaire/process/message de connexion)
	 * Désactiver la méthode en cas d'AJAX
	 *
	 * @return void
	 */
	private function _redirectLinkManagement() {

		# AJAX ? => Skip
		if($this->Router->isAjaxRequest()) { return; }

		# Désactivé pour les pages de connexion
		if(in_array($this->Router->getId(), ['CONNECTION_FORM', 'CONNECTION_LOGIN', 'CONNECTION_LOGOUT'], true)) { return; }

		$this->Session->deleteRedirectLink();
	}

	/**
	 * Set Error To Exception
	 *
	 * @return void
	 */
	private function _errorToException() {
		set_error_handler(function ($iSeverity, $sMessage, $sFileName, $iLine, $aContext) {
			throw new ErrorException($sMessage, 0, $iSeverity, $sFileName, $iLine);
		});
	}

	/**
	 * Chargement du controller
	 *
	 * @return void
	 */
	private function _loadController() {

		# Controller Path
		$sControllerPath = $this->Router->getController();

		# Vérification Information de Route
		$bMatched = preg_match('`^(?P<project_code>[a-z]+)\\\(?P<controller>.*)::(?P<method>[a-z0-9\-_]+)$`i', $sControllerPath, $aMatches);
		$sProjectCode = empty($aMatches['project_code']) ? '' : $aMatches['project_code'];
		$sController = empty($aMatches['controller']) ? '' : $sProjectCode . '\\' . $aMatches['controller'];
		$sMethod = empty($aMatches['method']) ? '' : $aMatches['method'];

		# NOT MATCH : Other requested file ? / else 404
		if (!$bMatched || !$sProjectCode || !$sController || !$sMethod) {
			$this->allowRequestedFile('robots.php');
			$this->Error->error404();
			exit;
		}

		# Not callable : 500
		if(!is_callable([$sController, $sMethod])) {
			$this->Error->error500(); exit;
		}

		# Détection statique / instance
		(new ReflectionMethod($sController, $sMethod))->isStatic() ? $sController::{$sMethod}($this) : (new $sController($this))->{$sMethod}($this);

	}

	/**
	 * PERMET DE CHARGER CERTAINS FICHIERS
	 *
	 * Si les fichiers sont dans la liste : chargement + exit
	 * Sinon return void => suite du code => error 404
	 *
	 * @param string|array $mFileName
	 * @return void
	 */
	private function allowRequestedFile($mFileName) {

		/**
		 *
		 * @todo voir l'abstract, faire une classe pour charger des fichiers public ou privé avec des options
		 *
		 */

		$sRequestedFile = trim($this->Router->getCurrentURL(), '/');
		if(is_string($mFileName)) $mFileName = [$mFileName];
		if(!in_array($sRequestedFile, $mFileName, true)) return;
		if(file_exists($sRequestedFile)) include($sRequestedFile); exit;
	}

}