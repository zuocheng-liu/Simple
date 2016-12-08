<?php
class Console_TestExecutor extends Console_Executor {
    public function test() {
        var_dump($this->_params);
    }
}
