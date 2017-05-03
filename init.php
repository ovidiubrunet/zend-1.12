<?php

// define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', __DIR__ . '/application');

// Define application environment
//defined('APPLICATION_ENV')
//	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

define('APPLICATION_ENV', 'development');

// set include path 
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../vendor/zendframework/zendframework1/library')
)));

//require autoload from vendor
require_once realpath(APPLICATION_PATH . '/../vendor/autoload.php');

require_once 'Zend/Config/Ini.php';
require_once 'Zend/Application.php';

class Application
{

	public static $env;

	public static function bootstrap($resource = null)
	{
		include_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Saffron_');
		$application = new Zend_Application(self::_getEnv(), self::_getConfig());
		return $application->getBootstrap()->bootstrap($resource);
	}

	public static function run()
	{
		self::bootstrap()->run();
	}

	private static function _getEnv()
	{
		return self::$env ? : APPLICATION_ENV;
	}

	private static function _getConfig()
	{
		$env = self::_getEnv();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env, true);
		return $config->toArray();
	}

}