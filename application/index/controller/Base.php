<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Config as ConfigModel;
use think\facade\Session;
use app\common\model\User as UserModel;

class Base extends Controller
{
    protected function initialize()
    {
        if(!request()->isAjax()){
            // 读取站点设置信息
            $site = ConfigModel::siteSetting();
            $this->assign('site', $site);

            //页面提示信息
            $flash = [];
            $flash_names = ['success', 'info', 'warning', 'danger'];
            foreach ($flash_names as $key => $name) {
                if (Session::has($name)) {
                    $flash[$name] = Session::pull($name);
                }
            }
            $this->assign('flash', $flash);
        }

        //当前登录用户
        $current_user = UserModel::currentUser();
        $this->assign('current_user', $current_user);
    }
}
