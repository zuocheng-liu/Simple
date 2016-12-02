<?php
namespace Simple\DB\PDO;
use Simple\DB\Enum\Configure;
class Manager {
    protected static $_instance = null;
    protected $_PDO_POOL = array();
    protected $_db_config = array();
    
    public static function getInstance() {
        if(!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function setDBConfig(array $config) {
        $this->_db_config = $config;
    }

    protected function _getMasterHostByDatabase($database) {
        if (empty($this->_db_config)) {
            return NULL;
        }
        if (!isset($this->_db_config[Configure::CONFIG_DATABASE][$database])) {
            return NULL;
        } 
        if (empty($this->_db_config[Configure::CONFIG_DATABASE][$database])) {
            return NULL;
        }
        $databaseConf = $this->_db_config[Configure::CONFIG_DATABASE][$database];
        if (!isset($databaseConf[Configure::CONFIG_DATABASE_MASTER]) || empty($databaseConf[Configure::CONFIG_DATABASE_MASTER])) {
            return NULL;
        }
        return $databaseConf[Configure::CONFIG_DATABASE_MASTER];
    }

    protected function _getSlaveHostByDatabase($database) {
        if (!isset($this->_db_config[Configure::CONFIG_DATABASE][$database])) {
            return NULL;
        } 
        if (empty($this->_db_config[Configure::CONFIG_DATABASE][$database])) {
            return NULL;
        }
        $databaseConf = $this->_db_config[Configure::CONFIG_DATABASE][$database];
        if (!isset($databaseConf[Configure::CONFIG_DATABASE_SLAVER]) || empty($databaseConf[Configure::CONFIG_DATABASE_SLAVER])) {
            return NULL;
        }
        return $databaseConf['master'];
    }


    public function getPDO($db , $connectToMaster = false) {
        $dbInfo = Config_DB::$DATABASES[$db];
        $hostInfo = $this->_selectHost($dbInfo, $connectToMaster);
        $key = $hostInfo['host'] . $hostInfo['port'] . $dbInfo['dbname'];
        if (!isset($this->_PDO_POOL[$key])) {
            $this->_PDO_POOL[$key] = $this->_createPDO($hostInfo, $dbInfo);
        return $this->_PDO_POOL[$key];
    }
    
    public function getReadOnlyPDO($database) {
        $hostInfo = $this->_selectHost();
        $key = $hostInfo['host'] . $hostInfo['port'] . $dbInfo['dbname'];
        if (!isset($this->_PDO_POOL[$key])) {
            $this->_PDO_POOL[$key] = $this->_createPDO($hostInfo, $dbInfo);
        }
        return $this->_PDO_POOL[$key];

    }

    public function getWritablePDO($database) {
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
          throw new Simple\Exception('Simple_MVC_Create_PDO_Error! '.'<br />'. $dsn .'<br />'. $hostInfo['user'] .'<br />'. $hostInfo['password'] );
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
    
    public static function getDSN($dbms, $host, $dbname, $port = 3306, $charset = 'utf8') {
        $dsn = null;
        if($dbms == null || $host == null || $dbname == null)
            return null;
        return "$dbms:host=$host;port=$port;dbname=$dbname;charset=$charset";
    }

}
