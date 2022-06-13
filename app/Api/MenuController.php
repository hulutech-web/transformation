<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use MenuService;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function menulist()
    {
        $user = Auth::user();
        //id为1的是超级管理员
        if ($user->id == 1) {
            $menus = config('menus');
            return $menus;
        } else {
            //如果用户没有角色
            if (empty($user->roles)) {
                return $this->error('没有权限，请联系管理员');
            } else {
                return $this->getMenus();
            }
        }
    }

    //初始化全局菜单
    public function generateMenus()
    {
        MenuService::init();
        return $this->message('菜单初始化完成');
    }

    //获取当前登录用户的菜单

    protected function getMenus()
    {
        $user = Auth::user();
        $permissions = $user->getPermissionsViaRoles();
//        return $permissions;
        $menus = MenuService::filterMenus($permissions);
        return $menus;
    }
}
