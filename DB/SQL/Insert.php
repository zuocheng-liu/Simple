<?php
class DB_SQL_Insert extends DB_SQL_Abstract { 
	protected $_keys = array();
	protected $_values = array();
	
	protected function _analyseData($data) {
		foreach ($data as $key => $value) {
			if (!empty($value) && !empty($key)) {
				$this->_keys[] = "`${key}`";
				
				$value = $this->_valueFilter($value);
				$this->_values[] = "'$value'";
			}
		}
	}
	public function toString($clear = false) {
		$sql = self::$_sqlTemplate[self::INSERT];
		$sql = str_replace("__KEYS__", implode(",", $this->_keys), $sql);
		$sql = str_replace("__VALUES__", implode(",", $this->_values), $sql);
		$sql = $this->_buildSql($sql);
		if ($clear)	$this->_clear();
		return $sql;
	}
	
	public function setParams($data) {
		$this->_analyseData($data);
	}
	
	public function _clear() {
		parent::_clear();
		$this->_keys = array();
		$this->_values = array();
	}
}