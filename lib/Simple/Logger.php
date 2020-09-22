<?php
namespace Simple;

class Logger {
    
    const TRACE = 32;
    const DEBUG = 16;
    const INFO = 8;
    const WARN = 4;
    const ERROR = 2;
    const FATAL = 1;

    protected $MODULE = '';
    protected $_logDir = '';
    protected static $_instance = null;

    public static function getInstance() {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function _write($level , $msg) {
    }
    public function trace($msg) {
        $this->_write(self::TRACE, $msg);
    }
    public function debug($msg) {
        $this->_write(self::DEBUG, $msg);
    }
    public function info($msg) {
        $this->_write(self::INFO, $msg);
    }
    public function warn($msg) {
        $this->_write(self::WARN, $msg);
    }
    public function error($msg) {
        $this->_write(self::ERROR, $msg);
    }
    public function fatal($msg) {
        $this->_write(self::FATAL, $msg);
    }
}
