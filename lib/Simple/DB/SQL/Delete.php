<?php
class DB_SQL_Delete extends DB_SQL_Abstract {

	public function toString($clear = false) {
		$sql = self::$_sqlTemplate[self::DELETE];
		$sql = $this->_buildSql($sql);
		if($clear) {
			$this->_clear();
		}
		return $sql;
	}
	public function _clear() {
		parent::_clear();
	}
}