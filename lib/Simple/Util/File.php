<?php
#http://www.laruence.com/2012/05/02/2613.html
    $file = "/tmp/中文名.tar.gz";
 
    $filename = basename($file);
 
    header("Content-type: application/octet-stream");
 
    //处理中文文件名
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $encoded_filename = rawurlencode($filename);
    if (preg_match("/MSIE/", $ua)) {
     header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
    } else if (preg_match("/Firefox/", $ua)) {
     header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
    } else {
     header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
 
    //让Xsendfile发送文件
    header("X-Sendfile: $file");