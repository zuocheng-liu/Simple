<?php
class DB_PDO_Manager {
    protected static $_instance = null;
    protected $_PDO_POOL = array();
    
    public static function getInstance() {
        if(!self::$_instance instanceof DB_PDO_Manager) {
            self::$_instance = new DB_PDO_Manager();
        }
        return self::$_instance;
    }
    public function getPDO($db , $connectToMaster = false) {
        $dbInfo = Config_DB::$DATABASES[$db];
        $hostInfo = $this->_selectHost($dbInfo, $connectToMaster);
        $key = $hostInfo['host'] . $hostInfo['port'] . $dbInfo['dbname'];
        if (!isset($this->_PDO_POOL[$key])) {
            $this->_PDO_POOL[$key] = $this->_createPDO($hostInfo, $dbInfo);
        }
        return $this->_PDO_POOL[$key];
    }
    protected function _createPDO($hostInfo, $dbInfo) {
        $dsn = Util_PDO::getDSN($hostInfo['dbms'], $hostInfo['host'], $dbInfo['dbname'],$hostInfo['port'], 'utf8');
        try {
            $pdo = new PDO($dsn, $hostInfo['user'], $hostInfo['password']);
            /*
             * long connection
            $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
             */
           // $pdo->query('set names charset ' . isset($dbInfo['charset']) ? $dbInfo['charset'] : Config_DB::NAMES);
            
        } catch(PDOException $e) {
          throw new Simple_Exception('Simple_MVC_Create_PDO_Error! '.'<br />'. $dsn .'<br />'. $hostInfo['user'] .'<br />'. $hostInfo['password'] );
        }
        return $pdo;
    }
    protected function _selectHost($dbInfo, $connectToMaster = false) {
        if ($connectToMaster) {
            return Config_Hosts::$DATEBASE[$dbInfo['master']];
        }
        $dbnum = count($dbInfo['hosts']);
        $dbNo = rand() % $dbnum;
        return Config_Hosts::$DATEBASE[$dbInfo['hosts'][$dbNo]];
    }
}
