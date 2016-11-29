<?php
abstract class DB_SQL_Abstract {
	const DELETE = 0;
	const UPDATE = 1;
	const INSERT = 2;
	const SELECT = 3;
	protected static $_sqlTemplate = array(
			self::DELETE => 'DELETE FROM __TABLE__ WHERE __CONDITION__',
			self::UPDATE => 'UPDATE __TABLE__ SET __KEY_VALUE__ WHERE __CONDITION__',
			self::INSERT => 'INSERT INTO __TABLE__ ( __KEYS__ ) VALUES ( __VALUES__ )',
			self::SELECT => 'SELECT __ATTRS__ FROM __TABLE__ WHERE __CONDITION__',
			);
	protected $_tables = array();
	protected $_where = null;
	protected $_groupby = null;
	protected $_cond = null;
	
	abstract function toString($clear = false);
	
	protected function _clear() {
		$this->_cond = null;
		$this->_where = null;
		$this->_tables = array();
	}
	public function addTables($tables) {
		foreach ($tables as $table) {
			$this->_tables[] = "`${table}`";
		}
	}
	public function addTable($table) {
		$this->_tables[] = "`${table}`";
	}
	public function addWhere(DB_SQL_Where $where) {
		$this->_where = $where;
	}
	public function getWhere() {
		if (!$this->_where instanceof DB_SQL_Where) {
			$this->_where = new DB_SQL_Where();
		}
		return $this->_where;
	}
	public function addCond($condition) {
		$this->_cond = $condition;
	}
	protected function _buildSql($sql){
		$sql = str_replace("__TABLE__", implode(", ", $this->_tables), $sql);
		if ($this->_groupby instanceof DB_SQL_Groupby) {
			$sql = str_replace('WHERE', 'GROUP BY', $sql);
			$sql = str_replace('__CONDITION__', $this->_groupby->toString(), $sql);
		} elseif ($this->_where instanceof DB_SQL_Where) {
			$sql = str_replace('__CONDITION__', $this->_where->toString(), $sql);
		} elseif ($this->_cond == null) {
			$sql = str_replace('__CONDITION__', '1', $sql);
		} else {
			$sql = str_replace('__CONDITION__', $this->_cond, $sql);
		}
		return $sql;
	}
	protected function _valueFilter($value) {
      //return mysql_real_escape_string($value);
      return $value;
	}
}