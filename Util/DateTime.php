<?php
class Util_DateTime {
	public static function getSqlDateTime($time = null) {
		if(!$time) $time = time();
		return date('Y-m-d H:i:s', $time);
	}
	public static function getSqlDate($time = null) {
		if(!$time) $time = time();
		return date('Y-m-d', $time);
	}
	public static function getSqlTime($time = null) {
		if(!$time) $time = time();
		return date('H:i:s', $time);
	}
    public static function hourToDecimal($time,$precision = 2) {        
        $second = $time % 3600;
        $hour = date('G',$time);
        $decimal = $hour + $second / 3600;
        return round($decimal, 2);
    }
}