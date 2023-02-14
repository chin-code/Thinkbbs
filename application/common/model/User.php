<?php

namespace app\common\model;

use think\Model;

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
}
