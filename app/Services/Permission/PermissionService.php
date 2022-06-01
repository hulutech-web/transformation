<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

/**
 * 权限菜单
 * @package App\Services
 */
class PermissionService
{
    public function getDeepPermission($data)
    {
        //递归获取所有节点
        foreach ($data as $item) {
            Permission::create(['name' => $item['name'], 'title' => $item['meta']['title'], 'description' => $item['meta']['description'], 'guard_name' => 'sanctum']);
            if (isset($item['children'])) {
                $this->getDeepPermission($item['children']);
            }
        }
    }
}
