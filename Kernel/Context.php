<?php
namespace Simple/Kernel;
class Context {
    protected $_controller = null;
    protected $_action = null;
    protected $_servername = null;
    protected $_port = null;
    protected $_requesturi = null;
    protected $_params = array();

    public function __construct() {
        $this->_servername = $_SERVER['SERVER_NAME'];
        $this->_port = $_SERVER['SERVER_PORT'];
        $this->_params = array_merge($_GET,$_POST);
        $this->_requesturi = strtok($_SERVER['REQUEST_URI'], '?');
        
        if($this->_requesturi == "/") {
            $this->_controller = null;
            $this->_action = null;
        }   
        $this->_controller = strtok($this->_requesturi, "/");
        $this->_action = strtok("/");
        if ($this->_action) {
            $this->_action = trim(substr($this->_requesturi,strlen($this->_controller) + 2));
        } else {
            $this->_action = $this->_controller;
            $this->_controller = null;
        }
    }
    public function getController() {
        return $this->_controller;
    }
    public function getAction() {
        return $this->_action;
    }
    public function getParams($cookie = false) {
        if($cookie) {
            return array_merge($this->_params, $_COOKIE);
        }
        return $this->_params;
    }
    public function getParam($name, $type = null, $default = null, $cookie = false) {
        $param = $default;
        if ($cookie && isset($_COOKIE[$name])) {
            $param = $_COOKIE[$name];
        } elseif (!empty($this->_params) && isset($this->_params[$name])) {
            $param = $this->_params[$name];
        } 
        if($type) {
            settype($param, $type);
        }
        return $param;
    }
    public function setParam($key, $value) {
        $this->_params[$key] = $value;
    }
    public function addParams(array $params) {
        $this->_params = array_merge($this->_params, $params);
    }
    public function setParams(array $params) {
        $this->_params = $params;
    }
    public function setCookies(array $cookies, $expire = null) {
        if(!$expire) {
            $expire = Config_Env::DEFAULT_COOKIE_EXPIRES;
        }
        foreach ($cookies as $name => $value) {
            setcookie($name,$value,$expire);
        }
    }
    public function getCookies() {
        return $_COOKIE;
    }
}
