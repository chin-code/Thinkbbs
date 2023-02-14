<?php

namespace app\common\model;

use think\Model;
use app\common\validate\User as Validate;
use app\common\exception\ValidateException;

class User extends Model
{
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
}
