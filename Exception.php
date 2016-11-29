<?php 
namespace Simple;
class Exception extends Exception {
    protected $_error;
    public function getErrorNo() {
        return $this->_error;
    }
}
