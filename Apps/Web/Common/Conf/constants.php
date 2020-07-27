<?php
/**
 * 判断是否启用Memcached
 *
 */
if (C('DATA_CACHE_TYPE')=='Memcache' && C('MEMCACHE')!=null) {
    S(C('MEMCACHE'));
}

/**
 * 定义cookie相关的常量
 *
 */
if (!defined('COOKIEHASH')) {
    if (C('url.site')) {
        define( 'COOKIEHASH', hash('md5', (C('url.site'))) );
    } else {
        define('COOKIEHASH', '');
    }
}

if (!defined('LOGGED_IN_COOKIE')) {
    define('LOGGED_IN_COOKIE', 'yg_logged_in_' . COOKIEHASH);
}