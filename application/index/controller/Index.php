<?php
namespace app\index\controller;

use think\Controller;
use tpadmin\model\Config as ConfigModel;

class Index extends Base
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
