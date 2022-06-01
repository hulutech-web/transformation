<?php

namespace App\Services\Menu;


use App\Models\Menu;

/**
 * 权限菜单
 * @package App\Services
 */
class MenuService
{
    public function init()
    {
        //如果菜单表不为空，清空菜单表
        if (Menu::count() > 0) {
            Menu::truncate();
        }
        $menus = config('menus');
        array_map(function ($menu) {
            Menu::create($menu);
        }, $menus);
    }

    protected function deepPutMenus($data)
    {
        //递归获取所有节点
        foreach ($data as $item) {
            Menu::create(['name' => $item['name'], 'title' => $item['meta']['title'], 'description' => $item['meta']['description'], 'guard_name' => 'sanctum']);
            if (isset($item['children'])) {
                $this->getDeepPermission($item['children']);
            }
        }
    }

    public function filterMenus($permissions)
    {
        $menuIds = [];
        $menus = Menu::all();
        foreach ($permissions as $permission) {
            foreach ($menus as $menu) {
                if ($permission->name == $menu->name) {
                    array_push($menuIds, $menu->id);
                }
            }
        }
        //        return $menuIds;
        //查找ID在数组中的菜单
        $menus = Menu::whereIn('id', $menuIds)->get();
        return $menus->toTree();
    }
}
