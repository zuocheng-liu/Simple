<?php
class Console_Executor {
    protected $_params = array();
    function __construct() {
        $index = 0;
        $newArgc = $_SERVER['argc'] - 2 ;
        while ($index < $newArgc) {
            $this->_params[$index] = trim($_SERVER['argv'][$index + 2]);
            $index++; 
        }
    }

    protected function getParams() {
        return $this->_params;
    }
}
