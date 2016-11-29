<?php
class DB_Mongo_Manager {
    protected static $_instance = null;
    protected $_DB_POOL = array();
    
    public static function getInstance() {
        if(!self::$_instance instanceof DB_Mongo_Manager) {
            self::$_instance = new DB_Mongo_Manager();
        }
        return self::$_instance;
    }
    public function getMongo($db) {
        $dbInfo = Config_DB::$DATABASES[$db];
        $hostInfo = $this->_selectHost($dbInfo);
        $key = $hostInfo['host'] . $hostInfo['port'];
        if (!isset($this->_DB_POOL[$key])) {
            $this->_DB_POOL[$key] = $this->_createPDO($hostInfo, $dbInfo);
        }
        return $this->_DB_POOL[$key];
    }
    protected function _createMongo($hostInfo, $dbInfo) {
        try {
            $pdo = new PDO($dsn, $hostInfo['user'], $hostInfo['password']);
            $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
            $pdo->query('set names ' . isset($dbInfo['charset']) ? $dbInfo['charset'] : Config_DB::NAMES);
        } catch(PDOException $e) {
            throw new Simple_Exception('Simple_MVC_Create_PDO_Error! '.'<br />'. $dsn .'<br />'. $hostInfo['user'] .'<br />'. $hostInfo['password'] );
        }
        return $pdo;
    }
}