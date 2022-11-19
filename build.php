<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 定义共公模块的自动生成
    'common'     => [
        '__file__'   => [],
        '__dir__'    => ['exception', 'model', 'observer', 'validate'],
        'controller' => [],
        'model'      => [],
        'view'       => [],
    ],

    // 定义前台模块的自动生成
    'index'     => [
        '__file__'   => [],
        '__dir__'    => ['config', 'controller', 'index'],
        'controller' => [],
        'model'      => [],
        'view'       => ['index/index'],
    ],

    // 定义后台模块的自动生成
    'admin'     => [
        '__file__'   => [],
        '__dir__'    => ['config', 'controller', 'index'],
        'controller' => ['Index'],
        'model'      => [],
        'view'       => [],
    ],
];
