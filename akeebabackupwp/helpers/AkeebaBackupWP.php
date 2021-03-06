<?php

use Akeeba\Engine\Platform;
use Awf\Mvc\Model;

/**
 * @package		akeebabackupwp
 * @copyright	2014-2017 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

class AkeebaBackupWP
{
	/** @var string The name of the wp-content/plugins directory we live in */
	public static $dirName = 'akeebabackupwp';

	/** @var string The name of the main plugin file */
	public static $fileName = 'akeebabackupwp.php';

	/** @var string Absolute filename to self */
	public static $absoluteFileName = null;

	/** @var array List of all JS files we can possibly load */
	public static $jsFiles = array();

	/** @var array List of all CSS files we can possibly load */
	public static $cssFiles = array();

	/** @var bool Do we have an outdated PHP version? */
	public static $wrongPHP = false;

	/** @var string Minimum PHP version */
	public static $minimumPHP = '5.3.3';

	protected static $loadedScripts = array();

	/**
	 * Store the unquoted request variables to prevent WordPress from killing JSON requests.
	 */
	public static function fakeRequest()
	{
		// See http://stackoverflow.com/questions/8949768/with-magic-quotes-disabled-why-does-php-wordpress-continue-to-auto-escape-my
		global $_REAL_REQUEST;
		$_REAL_REQUEST = $_REQUEST;
	}

	/**
	 * Start a session (if not already started). It also takes care of our magic trick for displaying raw views without
	 * rendering WordPress' admin interface.
	 */
	public static function startSession()
	{
		// We no longer start a session; we are now using a session handler that uses nothing but the database
		/**
		if (!session_id())
		{
			session_start();
		}
		/**/

		$page = self::$dirName . '/' . self::$fileName;

		// Is this an Akeeba Solo page?
		if (isset($_REQUEST['page']) && ($_REQUEST['page'] == $page))
		{
			// Is it a format=raw, format=json or tmpl=component page?
			if (
				(isset($_REQUEST['format']) && ($_REQUEST['format'] == 'raw')) ||
				(isset($_REQUEST['format']) && ($_REQUEST['format'] == 'json')) ||
				(isset($_REQUEST['tmpl']) && ($_REQUEST['tmpl'] == 'component'))
			)
			{
				define('AKEEBA_SOLOWP_OBFLAG', 1);
				@ob_start();
			}
		}
	}

	/**
	 * Load template scripts with fallback to our own copies (useful for support)
	 */
	public static function loadJavascript()
	{
		// We no longer start a session; we are now using a session handler that uses nothing but the database
		/**
		if (!session_id())
		{
		session_start();
		}
		/**/

		$page = self::$dirName . '/' . self::$fileName;

		// Is this an Akeeba Solo page?
		if (!isset($_REQUEST['page']) || !($_REQUEST['page'] == $page))
		{
			return;
		}

		if (
			defined('AKEEBA_OVERRIDE_JQUERY') &&
			@file_exists(dirname(AkeebaBackupWP::$absoluteFileName) . '/app/media/js/jquery.min.js') &&
				@file_exists(dirname(AkeebaBackupWP::$absoluteFileName) . '/app/media/js/jquery-migrate.min.js')
		)
		{
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/jquery.min.js', self::$absoluteFileName));
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/akjqnamespace.min.js', self::$absoluteFileName));
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/jquery-migrate.min.js', self::$absoluteFileName));
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/bootstrap.min.js', self::$absoluteFileName));
		}
		else
		{
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/akjqnamespace.min.js', self::$absoluteFileName));
			AkeebaBackupWP::enqueueHeadScript(plugins_url('app/media/js/bootstrap.min.js', self::$absoluteFileName));
		}

		$theEntireUniverseOfScripts = array(
			'piecon', 'datepicker/bootstrap-datepicker', 'solo/gui-helpers',
			'solo/alice', 'solo/backup', 'solo/configuration', 'solo/dbfilters', 'solo/encryption', 'solo/extradirs',
			'solo/fsfilters', 'solo/multidb', 'solo/regexdbfilters', 'solo/regexfsfilters', 'solo/restore', 'solo/setup',
			'solo/stepper', 'solo/system', 'solo/update', 'solo/wizard'
		);

		$relPath = __DIR__ . '/../';

		foreach ($theEntireUniverseOfScripts as $script)
		{
			$scriptPath = 'app/media/js/' . $script . '.min.js';

			if (file_exists($relPath . $scriptPath))
			{
				AkeebaBackupWP::enqueueHeadScript(plugins_url($scriptPath, self::$absoluteFileName));
			}
		}
	}

	/**
	 * Terminate a session if it's already started
	 */
	public static function endSession()
	{
		if (session_id())
		{
			session_destroy();
		}
	}

	/**
	 * Part of our magic trick for displaying raw views without rendering WordPress' admin interface.
	 */
	public static function clearBuffer()
	{
		if (defined('AKEEBA_SOLOWP_OBFLAG'))
		{
			@ob_end_clean();
			exit(0);
		}
	}

	/**
	 * Installation hook. Creates the database tables if they do not exist and performs any post-installation work
	 * required.
	 */
	public static function install()
	{
		// Require WordPress 3.1 or later
		if (version_compare(get_bloginfo('version'), '3.1', 'lt'))
		{
			deactivate_plugins(self::$fileName);
		}

		// Register the uninstallation hook
		register_uninstall_hook(self::$absoluteFileName, array('AkeebaBackupWP', 'uninstall'));
	}

	/**
	 * Uninstallation hook
	 *
	 * Removes database tables if they exist and performs any post-uninstallation work required.
	 *
	 * @return  void
	 */
	public static function uninstall()
	{
		// @todo Uninstall database tables
	}

	/**
	 * Create the administrator menu for Akeeba Backup
	 */
	public static function adminMenu()
	{
		if (is_multisite())
		{
			return;
		}

		$page_hook_suffix = add_menu_page('Akeeba Backup', 'Akeeba Backup', 'edit_others_posts', self::$absoluteFileName, array('AkeebaBackupWP', 'boot'), plugins_url('app/media/logo/abwp-24-white.png', self::$absoluteFileName));

		//add_action('admin_print_scripts-' . $page_hook_suffix, array(__CLASS__, 'adminPrintScripts'));
	}

	/**
	 * Create the blog network administrator menu for Akeeba Backup
	 */
	public static function networkAdminMenu()
	{
		if (!is_multisite())
		{
			return;
		}

		add_menu_page('Akeeba Backup', 'Akeeba Backup', 'manage_options', self::$absoluteFileName, array('AkeebaBackupWP', 'boot'), plugins_url('app/media/logo/abwp-24-white.png', self::$absoluteFileName));
	}

	/**
	 * Boots the Akeeba Backup application
	 */
	public static function boot()
	{
		if (self::$wrongPHP)
		{
			include_once dirname(self::$absoluteFileName) . '/helpers/wrongphp.php';
			return;
		}

		// HHVM made sense in 2013, now PHP 7 is a way better solution than an hybrid PHP interpreter
		if (defined('HHVM_VERSION'))
		{
			include_once dirname(self::$absoluteFileName) . '/helpers/hhvm.php';

			return;
		}

		$network = is_multisite() ? 'network/' : '';

		if (!defined('AKEEBA_SOLO_WP_ROOTURL'))
		{
			define('AKEEBA_SOLO_WP_ROOTURL', site_url());
		}

		if (!defined('AKEEBA_SOLO_WP_URL'))
		{
			$bootstrapUrl = admin_url() . $network . 'admin.php?page=' . self::$dirName . '/' . self::$fileName;
			define('AKEEBA_SOLO_WP_URL', $bootstrapUrl);
		}

		if (!defined('AKEEBA_SOLO_WP_SITEURL'))
		{
			$baseUrl = plugins_url('app/index.php', self::$absoluteFileName);
			define('AKEEBA_SOLO_WP_SITEURL', substr($baseUrl, 0, -10));
		}

		include_once dirname(self::$absoluteFileName) . '/helpers/bootstrap.php';
	}

	/**
	 * Enqueues a Javascript file for loading
	 *
	 * @param   string  $url  The URL of the Javascript file to load
	 */
	public static function enqueueScript($url)
	{
		if (in_array($url, self::$loadedScripts))
		{
			return;
		}

		self::$loadedScripts[] = $url;

		if (!defined('AKEEBABACKUP_VERSION'))
		{
			@include_once dirname(self::$absoluteFileName) . '/app/version.php';
		}

		$handle = 'akjs' . md5($url);
		$dependencies = array('jquery', 'jquery-migrate');

		// When we override the loading of jQuery do not depend on WP's jQuery being loaded
		if (defined('AKEEBA_OVERRIDE_JQUERY') && AKEEBA_OVERRIDE_JQUERY)
		{
			$dependencies = array();
		}

		//wp_enqueue_script($handle, $url, $dependencies, AKEEBABACKUP_VERSION, false);

		$version = AKEEBABACKUP_VERSION;
		echo "<script type=\"text/javascript\" src=\"$url?$version\"></script>\n";
	}

	/**
	 * Enqueues a Javascript file for loading in the head
	 *
	 * @param   string  $url  The URL of the Javascript file to load
	 */
	public static function enqueueHeadScript($url)
	{
		if (in_array($url, self::$loadedScripts))
		{
			return;
		}

		self::$loadedScripts[] = $url;

		if (!defined('AKEEBABACKUP_VERSION'))
		{
			@include_once dirname(self::$absoluteFileName) . '/app/version.php';
		}

		$handle = 'akjs' . md5($url);
		$dependencies = array('jquery', 'jquery-migrate');

		// When we override the loading of jQuery do not depend on WP's jQuery being loaded
		if (defined('AKEEBA_OVERRIDE_JQUERY') && AKEEBA_OVERRIDE_JQUERY)
		{
			$dependencies = array();
		}

		wp_enqueue_script($handle, $url, $dependencies, AKEEBABACKUP_VERSION, false);
	}

	/**
	 * Enqueues a CSS file for loading
	 *
	 * @param   string  $url  The URL of the CSS file to load
	 */
	public static function enqueueStyle($url)
	{
		if (!defined('AKEEBABACKUP_VERSION'))
		{
			@include_once dirname(self::$absoluteFileName) . '/app/version.php';
		}

		$handle = 'akcss' . md5($url);
		wp_enqueue_style($handle, $url, array(), AKEEBABACKUP_VERSION);
	}

	/**
	 * Runs when the authentication cookie is being cleared (user logs out)
	 *
	 * @return  void
	 */
	public static function onUserLogout()
	{
		// Remove the user meta which are used in our fake session handler
		$userId         = get_current_user_id();
		$allMeta        = get_user_meta($userId);

		foreach ($allMeta as $key => $value)
		{
			if (strpos($key, 'AkeebaSession_') === 0)
			{
				delete_user_meta($userId, $key);
			}
		}
	}
}