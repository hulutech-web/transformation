<?php
return [
    [
        'id' => 1,
        'parent_id' => 0,
        'path' => '/admin/index',
        'icon' => 'bar-chart',
        'meta' => array(
            'title' => '首页',
            'permission' => 'admin.index',
            'description' => '展示后台首页',
        ),
        'name' => 'admin.index',
    ],
    [
        'id' => 2,
        'parent_id' => 0,
        'path' => '/admin/user',
        'icon' => 'user',
        'meta' => array(
            'title' => '用户管理',
            'permission' => 'admin.user',
            'description' => '展示所有用户管理页面',
        ),
        'name' => 'admin.user',
        'children' => array(
            [
                'id' => 3,
                'parent_id' => 2,
                'icon' => 'desktop',
                'path' => '/admin/user/index',
                'meta' => array(
                    'title' => '用户列表',
                    'permission' => 'admin.user.index',
                    'description' => '展示所有用户列表,您可以修改、删除、设置用户角色',
                ),
                'name' => 'admin.user.index',
            ])
    ],
    [
        'id' => 4,
        'parent_id' => 0,
        'path' => '/admin/car',
        'icon' => 'setting',
        'meta' => array(
            'title' => '汽车管理',
            'permission' => 'admin.car',
            'description' => '汽车报告管理',
        ),
        'name' => 'admin.car',
        'children' => array(
            [
                'id' => 5,
                'parent_id' => 4,
                'icon' => 'contacts',
                'path' => '/admin/car/index',
                'meta' => array(
                    'title' => '汽车报告列表',
                    'permission' => 'admin.car.index',
                    'description' => '展示汽车报告列表',
                ),
                'name' => 'admin.car.index',
            ], [
                'id' => 6,
                'parent_id' => 4,
                'icon' => 'contacts',
                'path' => '/admin/car/create',
                'meta' => array(
                    'title' => '汽车报告添加',
                    'permission' => 'admin.car.create',
                    'description' => '汽车报告添加',
                ),
                'name' => 'admin.car.create',
            ])
    ],
    [
        'id' => 7,
        'parent_id' => 0,
        'path' => '/admin/charge',
        'icon' => 'setting',
        'meta' => array(
            'title' => '充电桩管理',
            'permission' => 'admin.charge',
            'description' => '充电桩报告管理',
        ),
        'name' => 'admin.charge',
        'children' => array(
            [
                'id' => 8,
                'parent_id' => 7,
                'icon' => 'contacts',
                'path' => '/admin/charge/index',
                'meta' => array(
                    'title' => '充电桩报告列表',
                    'permission' => 'admin.charge.index',
                    'description' => '展示充电桩报告列表',
                ),
                'name' => 'admin.charge.index',
            ])
    ],

    [
        'id' => 9,
        'parent_id' => 0,
        'path' => '/admin/system',
        'icon' => 'setting',
        'meta' => array(
            'title' => '系统管理',
            'permission' => 'admin.system',
            'description' => '展示所有系统管理页面',
        ),
        'name' => 'admin.system',
        'children' => array(
            [
                'id' => 10,
                'parent_id' => 9,
                'icon' => 'contacts',
                'path' => '/admin/system/roles',
                'meta' => array(
                    'title' => '角色管理',
                    'permission' => 'admin.system.roles',
                    'description' => '展示所有角色管理页面,您可以初始化角色,并为角色添加权限',
                ),
                'name' => 'admin.system.roles',
            ],
            [
                'id' => 11,
                'parent_id' => 9,
                'icon' => 'insurance',
                'path' => '/admin/system/permissions',
                'meta' => array(
                    'title' => '权限管理',
                    'permission' => 'admin.system.permissions',
                    'description' => '初始化权限，全局菜单生成',
                ),
                'name' => 'admin.system.permissions',
            ],
            [
                'id' => 12,
                'parent_id' => 9,
                'icon' => 'car',
                'path' => '/admin/system/car',
                'meta' => array(
                    'title' => '汽车报告配置',
                    'permission' => 'admin.system.car',
                    'description' => '配置汽车报告项目字段',
                ),
                'name' => 'admin.system.car',
            ], [
                'id' => 13,
                'parent_id' => 9,
                'icon' => 'api',
                'path' => '/admin/system/charge',
                'meta' => array(
                    'title' => '充电桩报告配置',
                    'permission' => 'admin.system.charge',
                    'description' => '配置充电桩报告项目字段',
                ),
                'name' => 'admin.system.charge',
            ])
    ],
];