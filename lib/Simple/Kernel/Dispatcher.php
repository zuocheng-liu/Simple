<?php 
namespace Simple\Kernel;

include_once 'View.php';

class Dispatcher {

    protected $_view;
    protected $_uriPrefix;
    protected $_routeTable;
    
    function __construct() {
    }
    
    public function setView(View $view) {
        $this->_view = $view;
        return $this;
    }

    public function setUriPrefix($prefix) {
        $this->_uriPrefix = $prefix;
        return $this;
    }

    public function setRouteTable($table) {
        $this->_routeTable = $table;
        return $this;
    }

    public function dispatch($uri) {
                     
        if (!empty($this->_uriPrefix)) {
            $pos = strpos($uri, $this->_uriPrefix);
            if ($pos === false) {
                return 0;
            }
            if ($pos === 0) {
                $uri = substr($uri, strlen($this->_uriPrefix));
            }
            if ($prefix == $this->_uriPrefix) {
            }
        }
        $uri = rtrim($uri, "/");
        if (empty($uri) || '/' == $uri) {
            if (isset($this->_routeTable['/index']) && !empty($this->_routeTable['/index'])) {
                $config = $this->_routeTable['/index'];
            } else {
                return 0;
            }
        } elseif (isset($this->_routeTable[$uri]) && !empty($this->_routeTable[$uri])) {
            $config = $this->_routeTable[$uri];
        } elseif (isset($this->_routeTable['/404']) && !empty($this->_routeTable['/404'])) {
            $config = $this->_routeTable['/404'];
        } else {
            return 0;
        }

        if (isset($config['class']) 
            && !empty($config['class'])
            && isset($config['method'])
            && !empty($config['method'])
        ) {
            $this->__execfunc($config['class'], $config['method']);
        }
        if (isset($config['template']) && !empty($config['template'])) {
            $this->_view->addTemplate($config['template']);
            $this->_view->render();
        }
    }

    protected function __execfunc($classname,$method) {
        if($classname && $method) {
            $class = new $classname();
            $class->$method();
        }
    }
}
