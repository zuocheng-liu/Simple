<?php 
namespace Simple/Kernel;
class Dispatcher {
    protected $_allFilterCfg = null;
    function __construct() {
        $this->_allFilterCfg = $this->_getFilterCfg();
    }
	public function dispatch($module,$action) {
		 $config = $this->_getModuleConfig($module, $action);
		 if (isset($config['filter']) && !empty($config['filter'])) {
		     $this->_filterVerify($config['filter']);
		 }
		 if (isset($config['class']) && isset($config['method'])) {
		 	$this->__execfunc($config['class'], $config['method']);
		 }
		 if (isset($config['template']) && !empty($config['template'])) {
		 	Controller::getView()->addTemplate($config['template']);
		 	Controller::getView()->render();
		 }
	}
	protected function _getModuleConfig($module = null, $action = null) {
		if (empty($module)) {
			$config = $this->_getControllerConf(new Config_Controller_Default());
			if (empty($action)) 
				return $config['index'];
			if (isset($config[$action])) {
				return $config[$action];
			}
			$confClassName = 'Config_Controller_'.$action;
			if (Classloader::confClassExists($confClassName)) {
				$confClass = new $confClassName();
				$config = $this->_getControllerConf($confClass);
				return $config['index'];
			}
		}
		$confClassName = 'Config_Controller_'.$module;
		if (Classloader::confClassExists($confClassName)) {
			$confClass = new $confClassName();
			$config = $this->_getControllerConf($confClass);
			if (empty($action)) {
				return $config['index'];
			}
			if (isset($config[$action])) {
				return $config[$action];
			}
		}
		$config = $this->_getControllerConf(new Config_Controller_Default());
		return $config['404'];
	}
	protected function __execfunc($classname,$method) {
		if($classname && $method) {
			$class = new $classname();
			$class->$method();
		}
	}
	protected function _getControllerConf($conf) {
		return $conf->CONFIG;
	}
	protected function _getFilterCfg() {
	    return Config_Filter::$Filters;
	}
	protected function _filterVerify($cfg) {
	    $filterNames = explode(',', $cfg);
	    foreach ($filterNames as $filterName) {
	        $filter = $this->_allFilterCfg[trim($filterName)];
	        $this->__execfunc($filter['class'], $filter['method']);
	    }
	}
}
