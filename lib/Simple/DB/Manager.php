<?php
class DB_Manager {
	protected static $_instance = null;
	protected $_pdo = array();
	protected $_charset = null;
	protected $_toMaster = false;
	function __construct() {
	}
	public static function getInstance() {
		if(!self::$_instance instanceof DB_Manager) {
			self::$_instance = new DB_Manager();
		}
		return self::getInstance();
	}
	public static function createInsert($table = null ,$data = array()) {
		return new DB_SQL_Insert($table, $data);
	}
}