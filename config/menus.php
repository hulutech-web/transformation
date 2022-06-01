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
        'path' => '/admin/build',
        'icon' => 'solution',
        'meta' => array(
            'title' => '楼盘管理',
            'permission' => 'admin.build',
            'description' => '楼盘基本信息操作',
        ),
        'name' => 'admin.build',
        'children' => array([
            'id' => 5,
            'parent_id' => 4,
            'icon' => 'file-sync',
            'path' => '/admin/build/index',
            'meta' => array(
                'title' => '楼盘列表',
                'permission' => 'admin.build.index',
                'description' => '展示录入楼盘基本信息',
            ),
            'name' => 'admin.build.index',
        ], [
            'id' => 6,
            'parent_id' => 4,
            'icon' => 'funnel-plot',
            'path' => '/admin/build/create',
            'meta' => array(
                'title' => '添加楼盘',
                'permission' => 'admin.build.create',
                'description' => '录入楼盘基本信息',
            ),
            'name' => 'admin.build.create',
        ],
        )
    ],
    [
        'id' => 7,
        'parent_id' => 0,
        'path' => '/admin/owner',
        'icon' => 'schedule',
        'meta' => array(
            'title' => '业主管理',
            'permission' => 'admin.owner',
            'description' => '业主基本信息操作',
        ),
        'name' => 'admin.owner',
        'children' => array([
            'id' => 8,
            'parent_id' => 7,
            'icon' => 'link',
            'path' => '/admin/owner/index',
            'meta' => array(
                'title' => '业主列表',
                'permission' => 'admin.owner.index',
                'description' => '展示业主基本信息',
            ),
            'name' => 'admin.owner.index',
        ],
        )
    ],
    [
        'id' => 9,
        'parent_id' => 0,
        'path' => '/admin/contract',
        'icon' => 'wallet',
        'meta' => array(
            'title' => '合同管理',
            'permission' => 'admin.contract',
            'description' => '合同基本信息操作',
        ),
        'name' => 'admin.contract',
        'children' => array(
            [
                'id' => 10,
                'parent_id' => 9,
                'icon' => 'container',
                'path' => '/admin/contract/create',
                'meta' => array(
                    'title' => '录入合同',
                    'permission' => 'admin.contract.create',
                    'description' => '录入合同信息',
                ),
                'name' => 'admin.contract.create',
            ],
            [
                'id' => 11,
                'parent_id' => 9,
                'icon' => 'bars',
                'path' => '/admin/contract/index',
                'meta' => array(
                    'title' => '合同列表',
                    'permission' => 'admin.contract.index',
                    'description' => '展示合同列表',
                ),
                'name' => 'admin.contract.index',
            ]
        )
    ],
    [
        'id' => 12,
        'parent_id' => 0,
        'path' => '/admin/financial',
        'icon' => 'pay-circle',
        'meta' => array(
            'title' => '财务管理',
            'permission' => 'admin.financial',
            'description' => '合同出入账操作',
        ),
        'name' => 'admin.financial',
        'children' => array(
            [
                'id' => 13,
                'parent_id' => 12,
                'icon' => 'money-collect',
                'path' => '/admin/financial/index',
                'meta' => array(
                    'title' => '财务管理',
                    'permission' => 'admin.financial.index',
                    'description' => '合同出入账操作',
                ),
                'name' => 'admin.financial.index',
            ],
            [
                'id' => 14,
                'parent_id' => 12,
                'icon' => "history",
                'path' => '/admin/financial/query',
                'meta' => array(
                    'title' => '历史缴费',
                    'permission' => 'admin.financial.query',
                    'description' => '历史账目查询',
                ),
                'name' => 'admin.financial.query',
            ],
        )
    ],

    [
        'id' => 15,
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
                'id' => 16,
                'parent_id' => 15,
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
                'id' => 17,
                'parent_id' => 15,
                'icon' => 'insurance',
                'path' => '/admin/system/permissions',
                'meta' => array(
                    'title' => '权限管理',
                    'permission' => 'admin.system.permissions',
                    'description' => '初始化权限，全局菜单生成',
                ),
                'name' => 'admin.system.permissions',
            ])
    ],
];
