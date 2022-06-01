<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use PermissionService;
use Auth;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    //    初始化权限

    public function initPermissions()
    {
        $allPermissions = config('menus');
        //清空权限表
        //如果权限表不为空，则返回错误信息
        if (Permission::count() > 0) {
            return $this->error('权限表已存在');
        }
        PermissionService::getDeepPermission($allPermissions);
        return $this->message('初始化权限成功');
    }


    //同步角色的权限
    public function syncPermissions(Request $request, Role $role)
    {

        $permissions = $request->input();
        $role->syncPermissions($permissions);
        return $this->message('权限同步成功');
    }

    //获取角色的权限
    public function getPermissions(Request $request, Role $role)
    {
        $permissions = $role->permissions->pluck('name')->toArray();
        return $permissions;
    }
    // 默认权限
    public function getDefaultPermission()
    {
        $permissions = Permission::where('guard_name', 'sanctum')->get();
        return $permissions;
    }

    //获取当前用户的权限

    public function getUserPermissions()
    {
        $user = Auth::user();
        $permissions = $user->getPermissionsViaRoles();
        $permissions = $permissions->pluck('name')->toArray();
        return $permissions;
    }
}
