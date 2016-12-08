<?php
class DB_SQL_Operator {
	
	const EQ = '=';
	const NE = '!=';
	const GE = '>=';
	const GT = '>';
	const LT = '<';
	const LE = '<=';
	const IN = 'IN';
	const NOTIN = 'NOT IN';
	const LIKE = 'LIKE';
	const BT = 'BETWEEN';

	const _AND = 'AND';
	const _OR = 'OR';
	
	public static $setOperators = array(self::IN, self::NOTIN, self::BT);
}