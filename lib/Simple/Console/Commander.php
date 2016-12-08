#!/home/users/liuzuocheng/local/php/bin/php

<?php
$baseDir = realpath(dirname(__FILE__).'/../..').'/';
require_once $baseDir . 'Simple/Kernel/Initializer.php';
require_once $baseDir . 'Simple/Kernel/Controller.php';
require_once $baseDir . 'Simple/Kernel/Classloader.php';
Controller::getInitializer()->init();
try {
    if ($_SERVER['argc'] >= 2 && strlen($_SERVER['argv'][1]) > 0) {
        $cmd = $_SERVER['argv'][1];
        $config = Config_Console::$COMMANDS[$cmd];
        $class = $config['class'];
        $method = $config['method'];
        $excutor = new $class();
        $excutor->$method();
    } else {
        echo "Invalid Command\n";
    }
} catch (Exception $e) {
    echo date("Y-m-d H:i:s") . "\r\n";
    echo $e->getMessage() . $e->getTraceAsString() . "\r\n";
} 
