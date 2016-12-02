<?php 
namespace Simple\DB;
class Exception extends Simple\Kernel\Exception {
    protected $_error;
    public function getErrorNo() {
        return $this->_error;
    }
}
