<?php
class Util_VerificationCode {
	public static function createCode($length = 4) {
		if (empty($length) || $length < 1)
		{
			throw new Simple_Exception("createCode()函数参数($length)不得小于1");
		}
		//字符串源，这样写出来的目的是可以手动去除一些容易歧义的字符，比如具体环境中1与l、6与b很难区分
		$string = '2345789acdefghijkmnprstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
		$chars = str_split($string, 1);
		$output = '';
		for ($i=0; $i<$length; $i++)
		{
			$output .= $chars[rand(0, count($chars) - 1)];
		}
		return $output;
	} 
	public static function createImage($width = 80,$height = 25, $rand = "") {
		/*
		 * 生成图片验证码
		* and open the template in the editor.
		*/
		$img=imagecreatetruecolor($width,$height); //创建图片
		$bg=imagecolorallocate($img,0,0,0); //第一次生成的是背景颜色
		$fc=imagecolorallocate($img,255,255,255); //生成的字体颜色
		//给图片画线
		for($i=0;$i<3;$i++){
			$te=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
			$x0 = 0;
			$x1 = $width;
			$y0 =  rand(0,$height);
			$y1 =  rand(0,$height);
			imageline($img,$x0,$y0,$x1,$y1,$te);
		}
		//给图片画点
		for($i=0;$i<200;$i++){
			$te=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($img,rand()%100,rand()%30,$te);
		}
		//首先要将文字转换成utf-8格式
		//$str=iconv("gb2312","utf-8","呵呵呵");
		//加入中文的验证
		//smkai.ttf是一个字体文件，为了在别人的电脑中也能起到字体作用，把文件放到项目的根目录，可以下载，还有本机C:\WINDOWS\Fonts中有
		//imagettftext($img,11,10,20,20,$fc,"simkai.ttf","你好你好");
		//把字符串写在图片中
		imagestring($img,5,rand(3,10),rand(3,5),$rand,$fc);
		//输出图片  
		//ob_end_flush();
		//ob_end_clean();
		//header("Content-type:image/jpeg");
		//var_dump($rand);
		return $img;
	}
}