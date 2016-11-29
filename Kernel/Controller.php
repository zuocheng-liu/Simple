<?php 
namespace Simple/Kernel;
class Controller {
	protected static $_instance = null;
	protected static $_context = null;
	protected static $_dispatcher = null;
	protected static $_view = null;
	protected static $_initializer = null;
	public static function getInstance() {
		if (!self::$_instance instanceof Controller) {
			self::$_instance = new Controller();
		}
		return self::$_instance;
	}
	public static function getContext() {
		if (!self::$_context instanceof Context) {
			self::$_context = new Context();
		}
		return self::$_context;
	}
	public static function getDispatcher() {
		if (!self::$_dispatcher instanceof Dispatcher) {
			self::$_dispatcher = new Dispatcher();
		}
		return self::$_dispatcher;
	}
	public static function getView() {
		if (!self::$_view instanceof View) {
			self::$_view = new View();
		}
		return self::$_view;
	}
	public static function getInitializer() {
		if (!self::$_initializer instanceof Initializer) {
			self::$_initializer = new Initializer();
		}
		return self::$_initializer;
	}
	public function dispatch() {
		$context = Controller::getContext();
		$dispatcher = Controller::getDispatcher();
		ob_start();
		
		try {
		    $module = $context->getController();
		    $action = $context->getAction();
		    $dispatcher->dispatch($module,$action);
		} catch (Simple_Exception $e) {
		    $info['error'] = $e->getErrorNo(); 
		    $info['desc'] = $e->getMessage();
		    $info['trace'] = $e->getTraceAsString();
			Controller::getInstance()->forward('', 'error', $info);
		}
		ob_end_flush();
	}
	public function redirect($url) {
		header('Location:'.$url);
		//exit;
	}
	public function forward($module,$action,$params) {
		ob_end_clean();
		try {
		    Controller::getView()->addRenderVariables($params);
		    Controller::getDispatcher()->dispatch($module,$action);
		} catch (Simple_Exception $e) {
			echo $e->getFile().$e->getLine().$e->getMessage();
		}
		//exit;
	}
}
