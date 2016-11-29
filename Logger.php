<?php
class Logger {
	const DEBUG = 16;
	const INFO = 8;
	const WARN = 4;
	const ERROR = 2;
	const FATAL = 1;
	protected $MODULE = '';	
	protected static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance instanceof Logger) {
			self::$_instance = new Logger();
		}
		return self::$_instance;
	}
	public function _write($level , $msg) {
	}
	public function debug() {
		
	}
	public function info() {
	}
	public function warn() {
	}
	public function error() {
	}
	public function fatal() {
	}
}