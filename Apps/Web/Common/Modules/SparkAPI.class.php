<?php
namespace Common\Modules;

/**
 * Spark API
 *
 * @see Spark API相关的接口文档
 * @package Spark
 */
class SparkAPI
{
    /**
     * 获取首页相关信息
     * @return object | null
     */
    static function getIndexData() {
        $url = C('URL.spark') . '/Web_Index/getIndexData';
        $resp = httpGet($url);
        if (is_object($resp) && $resp->status == 200) {
            return $resp->data;
        }
        return null;
    }
}