<?php 
namespace Simple/Kernel;
class Classloader {
	public static function confClassExists($classname) {
		$classPath = Config_Env::$PRJ_DIR . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $classname).'.php';
		return file_exists($classPath);
	}
	public static function classExists($classname) {
		return class_exists($classname);
	}
	public static function startAutoLoader() {
		spl_autoload_register('ClassLoader::autoload');
	}
	public static function autoload($classname) {
		include_once str_replace(array('_','\\'), DIRECTORY_SEPARATOR, $classname).'.php';
	}
}
