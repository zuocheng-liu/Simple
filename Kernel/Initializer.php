<?php
namespace Simple/Kernel;
require_once realpath(dirname(__FILE__)."/../..") . "/Config/Env.php";
class Initializer {
	public static function init() {
		Classloader::startAutoLoader();
		self::_initEnv();
		self::_initPath();
	}
	protected static function _initEnv() {
		Config_Env::$PRJ_DIR = realpath(dirname(__FILE__)."/../..");
		//Config_Env::$PREFIX = isset($_SERVER['HTTP_HOST'])? "http://" . $_SERVER['HTTP_HOST'] : "http://www.zuocheng.net";
		Config_Env::$PREFIX = "http://www.zuocheng.net";
	}  
    protected static function _initPath() {
		set_include_path(get_include_path() . PATH_SEPARATOR . Config_Env::$PRJ_DIR . '/Simple');
		set_include_path(get_include_path() . PATH_SEPARATOR . Config_Env::$PRJ_DIR . '/Simple/Core');
		set_include_path(get_include_path() . PATH_SEPARATOR . Config_Env::$PRJ_DIR . '/Conf');
		set_include_path(get_include_path() . PATH_SEPARATOR . Config_Env::$PRJ_DIR);
		foreach (Config_Include::$PATHS as $path) {
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        }
	}
	protected static function _initDB() {
	}
}
