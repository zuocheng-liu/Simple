<?php
namespace Simple\Kernel;

include_once 'Classloader.php';

use Simple\Kernel\Classloader;

class Initializer {
    private $_uriPrefix = "";
    function __construct() {
        Classloader::startAutoLoader();
        $simpleFrameworkDir = realpath(dirname(__FILE__)) . '/../../';
        set_include_path(get_include_path() . PATH_SEPARATOR . $simpleFrameworkDir);

    }

    public function init() {
    }

    public function setProjectDir($productDir) {
        set_include_path(get_include_path() . PATH_SEPARATOR . $productDir);
        return $this;
    }
    
    public function getUriPrefix() {
        return $this->_uriPrefix;
    }

    public function setUriPrefix($prefix) {
        $this->_uriPrefix = $prefix;
        return $this;
    }

    public function getRouteTable() {
        return $this->_routeTable;
    }

    public function setRouteTable(array $routeTable) {
        $this->_routeTable = $routeTable;
        return $this;
    }
}
