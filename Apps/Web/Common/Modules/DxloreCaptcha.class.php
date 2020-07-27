<?php
namespace Common\Modules;

class DxloreCaptcha {
	
	// properties
	private $width = 95;
	private $height = 34;
	private $codes = '23456789qwertyuipasdfghjkzxcvbnmQWERTYUPASDFGHJKZXCVBNM';
	private $code_num = 4;	
	private $font_path;
	private $font_color;
	private $font_size = 20;
	private $bg_line = 6;
	private $bg_dot = 20;
	private $img;
	private $captcha;
	private $hashKey = 'appublisher';

	// init for datas
	public function __construct( $args = array() ) {
		$this->width = isset( $args['width'] ) ? $args['width'] : $this->width;		// set image width		
		$this->height = isset( $args['height'] ) ? $args['height'] : $this->height;		// set image height
		$this->codes = isset( $args['codes'] ) ? $args['codes'] : $this->codes;		// set codes
		$this->code_num = isset( $args['code_num'] ) ? $args['code_num'] : $this->code_num;		// set coude num
		$this->font_size = isset( $args['font_size'] ) ? $args['font_size'] : $this->font_size;	// set font size
		$this->bg_line = isset( $args['bg_line'] ) ? $args['bg_line'] : $this->bg_line;		// set random line for bg
		$this->bg_dot = isset( $args['bg_dot'] ) ? $args['bg_dot'] : $this->bg_dot;		// set random dot for bg
		$this->font_path = $_SERVER['DOCUMENT_ROOT'] . '/Public/files/fonts/elephant.ttf';
	}
	
	// create background
	private function create_bg() {
		$im = imagecreatetruecolor( $this->width, $this->height );
		$color = imagecolorallocate( $im, mt_rand( 157, 255 ), mt_rand( 157, 255 ), mt_rand( 157, 255 ) );
		imagefill( $im, 0, 0, $color );
		$this->img = $im;
	}
	
	// create line background
	private function create_line() {
		if( 0 == $this->bg_line )
			return;
		for( $i = 0; $i < $this->bg_line; $i++ ) {
			$color = imagecolorallocate( $this->img, mt_rand( 100, 156 ), mt_rand( 100, 156 ), mt_rand( 100, 156 ) );
			imageline( $this->img, mt_rand( 0, $this->width ), mt_rand( 0, $this->width ), mt_rand( 0, $this->height ), mt_rand( 0, $this->height ), $color );
		}
	}
	
	// create dot background
	private function create_dot() {
		if( 0 == $this->bg_dot )
			return;
		for( $i = 0; $i < $this->bg_dot; $i++ ) {
			$color = imagecolorallocate( $this->img, mt_rand( 100, 156 ), mt_rand( 100, 156 ), mt_rand( 100, 156 ) );
			imagesetpixel( $this->img,  mt_rand( 0, $this->width ), mt_rand( 0, $this->height ), $color );
		}
	}
		
	// create code
	private function create_code() {
		$len = strlen( $this->codes ) -1 ;
		$code = '';
		for( $i = 0; $i < $this->code_num; $i++ ) {
			$code .= substr( $this->codes, mt_rand( 0, $len ), 1 );
		}
		$this->captcha = $code;
		return $code;
	}
	
	// create font text
	private function create_font() {
		$angle = 0;
		$y = $this->height * 5 / 7;
		$average_width = $this->width / $this->code_num;
		for( $i = 0; $i < $this->code_num; $i++ ) {
			$this->font_color = imagecolorallocate( $this->img, mt_rand( 0,99 ), mt_rand( 0, 99 ), mt_rand( 0, 99 ) );
			$angle = mt_rand( -30, 30 );
			$x = $average_width * $i + mt_rand( 4, 6 );
			$code = substr( $this->captcha, $i, 1 );
			imagettftext( $this->img, $this->font_size, $angle, $x, $y, $this->font_color, $this->font_path, $code );
		}
	}
	
	// output img image
	private function output() {
		header( 'Content-type:image/png' );
		imagepng( $this->img );
		imagedestroy( $this->img );
	}

	/**
	 * 获取加密字符串的原文
	 *
	 * @param string $hashedCode 已加密的字符串
	 * @return string 字符串原文
	 */
	function decryptHashedCode($hashedCode) {
		$key = md5($this->hashKey);
		$x = 0;
		$str = '';
		$char = '';
		$data = base64_decode($hashedCode);
		$len = strlen($data);
		$l = strlen($key);
		for ($i = 0; $i < $len; $i++)
		{
			if ($x == $l)
			{
				$x = 0;
			}
			$char .= substr($key, $x, 1);
			$x++;
		}
		for ($i = 0; $i < $len; $i++)
		{
			if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
			{
				$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
			}
			else
			{
				$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
			}
		}
		$this->captcha = $str;
	}

	/**
	 * code加密
	 *
	 * @param string $code 待加密字符串
	 * @return string
	 */
	function encryptCode($code) {
		$char = '';
		$key = md5($this->hashKey);
		$x = 0;
		$len = strlen($code);
		$l = strlen($key);
		for ($i = 0; $i < $len; $i++) {
			if ($x == $l) {
				$x = 0;
			}
			$char .= $key{$x};
			$x++;
		}
		$str = '';
		for ($i = 0; $i < $len; $i++) {
			$str .= chr((ord($code{$i}) + ord($char{$i})) % 256);
		}
		return base64_encode($str);
	}

	public function getHashedCode() {
		$code = $this->create_code();

		return $this->encryptCode(strtolower($code));
	}

	public function validateCaptcha($inputCode, $hashedCode) {
		return $this->encryptCode(strtolower($inputCode)) === $hashedCode;
	}

	// do img 
	public function do_img($hashedCode) {
		$this->decryptHashedCode($hashedCode);
		$this->create_bg();
		$this->create_line();
		$this->create_dot();
		$this->create_font();
		$this->output();
	}	
	
}