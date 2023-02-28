<?php

namespace app\common\model;

use think\Model;
use app\common\validate\User as Validate;
use app\common\validate\Login as LoginValidate;
use app\common\exception\ValidateException;
use think\facade\Session;

class User extends Model
{
    public const CURRENT_KEY = "current_user";

    /**
     * @title 验证字段值是否唯一
     *
     * Date:2023/2/14 13:52
     */
    public static function checkFieldUnique($data,$id = 0)
    {
        $field_name = null;
        if (!isset($data['field'])) {
            return false;
        }
        $field_name = $data['field'];
        if(!isset($data[$field_name])) {
            return false;
        }
        $field_value = $data[$field_name];

        $query = static::where($field_name, $field_value);
        if ($id > 0) {
            $query->where('id','<>',$id);
        }
        if ($query->count()) {
            return false;
        }

        return true;
    }

    /**
     * @title 注册新用户
     *
     * Date:2023/2/14 14:30
     */
    public static function register($data)
    {
        $validate = new Validate;
        if (!$validate->batch(true)->check($data)) {
            $e = new ValidateException('注册数据验证失败');
            $e->setData($validate->getError());
            throw $e;
        }

        try {
            $user = new static;
            $user->allowField(['name','mobile','password'])->save($data);
        } catch (\Exception $e) {
            throw new \Exception('用户创建失败');
        }

        return $user;
    }

    /**
     * 密码保存时进行加密
     * @Author   zhanghong(Laifuzi)
     * @param    string             $value 原始密码
     */
    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * @title 用户登录
     *
     * Date:2023/2/28 12:30
     */
    public static function login($mobile,$password)
    {
        $errors = [];

        $validate = new LoginValidate;
        $data = ['mobile' => $mobile, 'password' => $password];
        if (!$validate->batch(true)->check($data)) {
            $e = new ValidateException('登录数据验证失败');
            $e->setData($validate->getError());
            throw $e;
        }

        $user = static::where('mobile', $mobile)->find();

        if (empty($user)) {
            //传输注册手机号码不存在
            $errors['mobile'] = '注册用户不存在';
        } else if(!password_verify($password, $user->password)) {
            //传输登录密码错误
            $errors['password'] = '登录手机或密码错误';
        }

        if (!empty($errors)) {
            $e = new ValidateException('登录数据验证失败');
            $e->setData($errors);
            throw $e;
        }

        //把去除登录密码以外的信息存储到 Session 里
        unset($user['password']);
        Session::set(static::CURRENT_KEY, $user);

        return $user;
    }

    /**
     * 当前登录用户
     * @Author   zhanghong(Laifuzi)
     * @return   User
     */
    public static function currentUser()
    {
        return Session::get(static::CURRENT_KEY);
    }

    /**
     * 退出登录
     * @Author   zhanghong(Laifuzi)
     * @return   bool
     */
    public static function logout()
    {
        Session::delete(static::CURRENT_KEY);
        return true;
    }
}
