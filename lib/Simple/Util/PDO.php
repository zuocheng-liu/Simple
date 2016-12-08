<?php
class Util_PDO {
    public static function getDSN($dbms, $host, $dbname, $port = 3306, $charset = 'utf8') {
        $dsn = null;
		if($dbms == null || $host == null || $dbname == null)
			return null;
		return "$dbms:host=$host;port=$port;dbname=$dbname;charset=$charset";
	}
}
