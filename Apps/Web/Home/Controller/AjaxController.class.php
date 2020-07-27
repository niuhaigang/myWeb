<?php
/**
 * ajax请求处理
 */

namespace Home\Controller;
use Common\Modules\SparkAPI;
use Think\Controller;

class AjaxController extends Controller {
    public function index(){
        $this->show('course', 'utf-8');
    }

    public function getAddress() {
        $province = I('get.province', '');
        $city = I('get.city', '');

        if (!empty($province)) {
            $list = getAddress('', '', 'city', urldecode($province));

        } elseif (!empty($city)) {
            $list = getAddress('', '', 'country', urldecode($city));
        } else {
            $this->ajaxReturn(array('code' => 0, 'msg' => '非法请求'));
        }

        $this->ajaxReturn(array('code' => 1, 'list' => $list));

    }
}