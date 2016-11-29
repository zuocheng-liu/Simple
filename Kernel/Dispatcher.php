<?php 
namespace Simple\Kernel;

class Dispatcher {
    protected $_uriPrefix;
    protected $_routeTable;
    
    function __construct() {
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
        
        if (empty($uri) || '/' == $uri) {
            if (isset($this->_routeTable['index']) && !empty($this->_routeTable['index'])) {
                $config = $this->_routeTable['index'];
            } else {
                return 0;
            }
        }

        if (isset($config['class']) 
            && !empty($config['class'])
            && isset($config['method'])
            && !empty($config['method'])
        ) {
            $this->__execfunc($config['class'], $config['method']);
        }

        if (isset($config['template']) && !empty($config['template'])) {
            Controller::getView()->addTemplate($config['template']);
            Controller::getView()->render();
        }
    }

    protected function __execfunc($classname,$method) {
        if($classname && $method) {
            $class = new $classname();
            $class->$method();
        }
    }
}
