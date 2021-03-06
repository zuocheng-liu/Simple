<?php 

namespace Simple\Kernel;

include_once 'Exception.php';

class View {
    /**
     * @var string 模板名
     */
    protected $_template = null;

    /**
     * @var array 用于渲染的变量数组
     */
    protected $_params = array();

    public function addRenderVariables(array $params) {
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
            try{
                extract($this->_params);
                require $this->_template;
            } catch (Simple\Kernel\Exception $e) {
                throw new Simple\Kernel\Exception($e->getMessage());
            }
        }
        $this->_clear();
    }
    public function _clear() {
        $this->_params = null;
        $this->_template = null;
    }
}
