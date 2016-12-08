<?php
class Util_Preg {
    protected $chinese = null;
    function __construct () {
        $this->chinese = "/^[".chr(0xa1)."-".chr(0xff)."A-Za-z0-9_]+$/";
    }
    const CHINESE_UTF8 = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u";
}
