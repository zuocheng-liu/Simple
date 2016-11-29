<?php
class DB_SQL_Update extends DB_SQL_Abstract{

	protected $_params = null;
	
	public function setParams($params) {
		foreach ($params as $key => $value) {
			if (!empty($this->_params))
				$this->_params .= ',';
			$this->_params .= " `${key}` = '${value}'";
		}
	}
	public function toString($clear = false) {
		$sql = self::$_sqlTemplate[self::UPDATE];
		$sql = str_replace("__KEY_VALUE__", $this->_params, $sql);
		$sql = $this->_buildSql($sql);
		if($clear) {
			$this->_clear();
		}
		return $sql;
	}
	public function _clear() {
		parent::_clear();
		$this->_params = null;
	}
}