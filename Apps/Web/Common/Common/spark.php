<?php
/**
 * Spark数据访问服务
 *
 * 此文件中定义的方法可以在别的地方重新定义，从而实现数据访问层的切换。
 * 例如：需要替换数据源获取方法，只需重定义这些方法即可。
 */

if (!function_exists('getIndexData')) :
    /**
     * 用户登录
     *
     * @see Common/Modules/SparkAPI.class.php
     * @return object|bool 成功返回用户信息，失败返回false
     */
    function getIndexData() {
        return \Common\Modules\SparkAPI::getIndexData();
    }
endif;

