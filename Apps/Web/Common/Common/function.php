<?php
/**
 * Description: 通用函数
 * User: devforma
 * Date: 15/6/18
 * Time: 10:37
 */



/**
 * get请求
 * @param string $url url地址
 * @param array $params 请求参数数组
 * @param bool $isJson 是否返回json
 * @return mixed|string
 */
function httpGet($url, $params = array(), $isJson = true) {
    if (strpos($url, 'appublisher.com') !== false)
        $params['terminal_type'] = 'pc_web';

    if (!empty($params))
        $url .= '?' . http_build_query($params);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $rawData = curl_exec($ch);
    if (!empty($rawData))
        return $isJson ? json_decode($rawData) : $rawData;

    return null;
}

/**
 * post请求
 * @param string $url url地址
 * @param array $params 参数数组
 * @param bool $isJson 是否返回json
 * @return mixed|string
 */
function httpPost($url, $params = array(), $isJson = true) {
    if (strpos($url, 'appublisher.com') !== false)
        $params['terminal_type'] = 'pc_web';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $rawData = curl_exec($ch);
    if (!empty($rawData))
        return $isJson ? json_decode($rawData) : $rawData;

    return null;
}

/**
 * 校验邮箱格式是否正确
 * @param string $str 待检验的字符串
 * @return bool email格式是否正确
 */
function validateEmail($str) {
    return filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
}


/**
 * 校验手机号格式是否正确
 * @param string $str 待检验的字符串
 * @return bool 手机号格式是否正确
 */
function validatePhone($str) {
    return preg_match('/^1[0-9]{10}$/', $str) != 0;
}


/**
 * 短信校验码格式的校验
 * @param string $str 待检验的字符串
 * @return bool 校验码格式是否正确
 */
function validateAuthCode($str) {
    return preg_match('/^[0-9]{6}$/', $str) != 0;
}


/**
 * 密码加密
 * @param string $data 待加密字符串
 * @param string $key 加密key
 * @return string
 */
function passEncrypt($data, $key) {
    $char = '';
    $key = md5($key);
    $x = 0;
    $len = strlen($data);
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
        $str .= chr((ord($data{$i}) + ord($char{$i})) % 256);
    }
    return base64_encode($str);
}

/**
 * 解析合并用户定义的参数到默认值
 *
 * @param string|array $args 要与$defaults合并的参数
 * @param array|string $defaults 可选。具体方法提供的默认值。默认为空。
 * @return array 合并结果
 */
function parseArgs($args, $defaults = '') {
	if (is_object($args)) {
		$vars = get_object_vars($args);
	} elseif (is_array($args)) {
		$vars =& $args;
	} else {
		parse_str($args, $vars);
		if (get_magic_quotes_gpc()) {
			foreach ($vars as $key=>$value) {
				$vars[$key] = stripcslashes($value);
			}
		}
	}

	if (is_array($defaults)) {
		return array_merge($defaults, $vars);
	}

	return $vars;
}