<?php

namespace app\index\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Register extends Base
{
    /**
     * 显示用户注册页面.
     *
     */
    public function create()
    {
        return $this->fetch('create');
    }

    /**
     * 保存用户注册数据
     *
     */
    public function save(Request $request)
    {
        $user = new User;
        $user->save($request->post());
        $message = "注册成功";
        //注册成功后跳转到首页
        return $this->success($message, '[page.root]');
    }


}
