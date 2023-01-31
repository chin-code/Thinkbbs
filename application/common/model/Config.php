<?php

namespace app\common\model;

use think\Model;
use tpadmin\model\Config as TpadminConfig;

class Config extends TpadminConfig
{
    public static function siteSetting()
    {
        $config = static::where('name',static::NAME_SITE_SETTING)->find();
        if (empty($config)) {
            return [];
        }
        return $config->settings;
    }
}
