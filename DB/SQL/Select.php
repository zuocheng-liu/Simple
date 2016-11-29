<?php
class DB_SQL_Select extends DB_SQL_Abstract {
	protected $_attrs = array();
	
	public function setAttr($attrs) {
		foreach ($attrs as $key) {
			$this->_attrs[] = "`${key}`";
		}
	}
	public function addAttr($attrs) {
		foreach ($attrs as $key) {
			$this->_attrs[] = "`${key}`";
		}
	}
	public function toString($clear = false) {
		$sql = self::$_sqlTemplate[self::SELECT];
		if (count($this->_attrs) > 0)
			$sql = str_replace("__ATTRS__", implode(", ", $this->_attrs), $sql);
		else 
			$sql = str_replace("__ATTRS__", "*", $sql);
		$sql = $this->_buildSql($sql);
		if ($clear) {
			$this->_clear();
		}
		return $sql;
	}
	public function getGroupby() {
		if (!$this->_groupby instanceof DB_SQL_Groupby) {
			$this->_groupby = new DB_SQL_Groupby();
		}
		return $this->_groupby;
	}
	public function addGrouby(DB_SQL_Groupby $groupby) {
		$this->_groupby = $groupby;
	}
	public function orderBy() {}
	public function limit() {}
	protected function _clear() {
		parent::_clear();
		$this->_attrs = array();
	}
}