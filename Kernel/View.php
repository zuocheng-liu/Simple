<?php 
namespace Simple\Kernel;
class View {
	/**
	* @var string 模板名
	*/
	protected $_template = null;
	
	/**
	* @var array 用于渲染的变量数组
	*/
	protected $_params = array();
	
	public function addRenderVariables($params) {
		$this->_params = array_merge($this->_params,$params);
	}
	public function addRenderVariable($name, $param) {
		$this->_params[$name] = $param;
	}
	public function addTemplate($template) {
		$this->_template = $template;
	}
	public function render() {
		header("Content-type: text/html; charset=utf-8");
		if($this->_template) {
			$Variables = json_encode($this->_params);
			$javascript = '<script type="text/javascript">var Variabiles =  '. $Variables . ';</script>' . "\r\n";
			try{
			    echo $javascript;
				require $this->_template;
			} catch (Simple_Exception $e) {
				throw new Simple_Exception($e->getMessage());
			}
		}
		$this->_clear();
	}
	public function _clear() {
		$this->_params = null;
		$this->_template = null;
	}
}
