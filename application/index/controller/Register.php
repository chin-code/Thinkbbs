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
        if (!$request->isPost() && !$request->isAjax()) {
            return $this->error('对不起，你访问的页面不存在。');
        }

        try {
            //保存表单提交数据
            $user = new User;
            $user->save($request->post());
        } catch (\Exception $e) {
            return $this->error('对不起，注册失败。');
        }

        //注册成功后跳转到首页
        return $this->success('恭喜你注册成功。', '[page.root]');
    }

    public function check_unique(Request $request)
    {
        if (!$request->isAjax()) {
            return $this->redirect('[page.signup]');
        }

        $param = $request->post();
        $is_valid = User::checkFieldUnique($param);
        if ($is_valid) {
            echo("true");
        } else {
            echo("false");
        }
    }


}
