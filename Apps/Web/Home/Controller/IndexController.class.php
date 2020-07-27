<?php
/**
 * 主页
 */
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $indexData = getIndexData();
        $this->assign('saying', $indexData->saying->saying);
        $this->assign('name', $indexData->saying->name);
        $this->assign('main', $indexData->welcome->main);
        $this->assign('word', $indexData->welcome->word);
        $this->display();
    }

}
