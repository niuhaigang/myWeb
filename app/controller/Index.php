<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        // return View::fetch();
        abort(500, '页面异常');
  
      
       
    }
   
    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
