<?php
return array(
    'URL_CASE_INSENSITIVE'  =>  true,
    'LANG_SWITCH_ON' => true,

    'MODULE_ALLOW_LIST'     =>  array('Home', 'Admin'),
    'DEFAULT_MODULE'        =>  'Home',

    'URL_HTML_SUFFIX'       => '', //去除伪静态后缀

    /* 模板相关 */
    'TMPL_TEMPLATE_SUFFIX'  => '.tpl', //默认模板文件后缀
    'TMPL_FILE_DEPR'        => '_', //模板的目录文件分隔符

    /* 错误设置 */
    'ERROR_MESSAGE'         =>  '404 - 页面不存在',//错误显示信息,非调试模式有效
    'ERROR_PAGE'            =>  '/page/404.html',	// 错误定向页面

    // 避免session阻塞，扫码等待机制尤其注意
    'SESSION_AUTO_START' => false,
//    'SESSION_TYPE' => 'Memcache',

    'LOAD_EXT_CONFIG' => 'constants',

    // URLs
    'URL' => array(
        'site' => '',
        'spark' => 'http://spark.niuhaigang.xyz/',
        'wap' => '',
        'cdn' => ''
    )
);