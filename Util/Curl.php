<?php
class Util_Curl {
    static public function grab($url) {
        return self::_grab($url);
    }
    static public function grabJsonToArray($url) {
        $output = self::_grab($url);
        //打印获得的数据
        $start = strpos($output,"{");
        $end = strpos($output,"}");
        $length = $end - $start + 1;
        $output = substr($output,$start,$length);
        if (preg_match('/\w:/', $output)) {
            $output = preg_replace('/(\w+):/is', '"$1":', $output);
        }
        $output = json_decode($output,true);

        return $output;
    }
    static protected function _grab($url) {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }
}
