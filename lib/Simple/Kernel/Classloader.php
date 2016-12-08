<?php 
namespace Simple\Kernel;
class Classloader {
    public static function classExists($classname) {
        return class_exists($classname);
    }
    public static function startAutoLoader() {
        spl_autoload_register('Simple\Kernel\ClassLoader::autoload');
    }
    public static function autoload($classname) {
        include_once str_replace(array('_','\\'), DIRECTORY_SEPARATOR, $classname).'.php';
    }
}
