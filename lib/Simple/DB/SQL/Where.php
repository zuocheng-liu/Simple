<?php
class DB_SQL_Where extends DB_SQL_Operator {	
	protected $_stack = array();
	protected $_datas = array();
	protected $_current = '';
	protected $_group = '';
	protected $_limit = '';  

	public function push() {
		if (!empty($this->_current)) {
			array_push($this->_stack, $this->_current);
		} else {
			throw new Simple_Exception('WherePushEmpty!');
		}
	}
	public function pushCurrent() {
		if (!empty($this->_current)) {
			array_push($this->_stack, $this->_current);
		} else {
			throw new Simple_Exception('WherePushEmpty!');
		}
	}
	public function popAnd() {
		if (empty($this->_stack)) {
			throw new Simple_Exception("CannotPopEmptyStack!");
		}
		$this->_current = '('.array_pop($this->_current).') '.self::_AND.' ('.$this->_current.')';
	}
	public function popOr() {
		if (empty($this->_stack)) {
			throw new Simple_Exception("CannotPopEmptyStack!");
		}
		$this->_current = '('.array_pop($this->_current).') '.self::_OR.' ('.$this->_current.')';
		
	}
	public function add($attr, $value, $op = '=' ,$type = 'AND') {
		if ($type == 'AND') {
			$this->addAnd($attr, $value, $op);
		} elseif ($type == 'OR') {
			$this->addOr($attr, $value, $op);
		} else {
			throw new Simple_Exception("${type} IsNeither'And'Or'OR'");
		}
	}
	public function addAnd($attr, $value, $op = '=') {
		if (!empty($this->_current))
			$this->_current .= ' AND ';
		if (in_array($op, self::$setOperators)) {
			if ($op == self::BT) {
				$this->_current .= "`${attr}` ".self::BT." $value[0] ".self::_AND." $value[1]";
			} else {
				$this->_current .= "`${attr}` ${op} (";
				foreach ($value as $element) {
					$this->_current .= "'${element}',";
				}
				$this->_current[strlen($this->_current) - 1] = ')';
			}
		} else {
			$this->_current .= "`${attr}` ${op} '${value}'";
		}
	}
	public function addOr($attr, $value, $op = '=') {
		if (!empty($this->_current))
			$this->_current .= ' OR ';
		if (in_array($op, self::$setOperators)) {
			if ($op == self::BT) {
				$this->_current .= "`${attr}` ".self::BT." $value[0] ".self::_AND." $value[1]";
			} else {
				$this->_current .= "`${attr}` $op (";
				foreach ($value as $element) {
					$this->_current .= "'$element',";
				}
				$this->_current[strlen($this->_current) - 1] = ')';
			}
		} else {
			$this->_current .= "`${attr}` $op '$value'";
		}
	}
	public function toString() {
		return $this->_current;
	}
	public function _clear() {}
} 
