<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MenuService;
use PermissionService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->init();
        return $next($request);
    }

    //初始化系統
    public function init()
    {
        $roleCheck = $this->initRoles();
        $permissionCheck = $this->initPermissions();
        return $roleCheck && $permissionCheck;
        //初始化菜單
    }

    public function initRoles(): bool
    {
        if (Role::all()->count() > 0) {
//            abort(404, '角色已存在');
            return false;
//            Role::truncate();
        }
        $roles = config('roles');

        foreach ($roles as $role) {
            Role::create(['name' => $role['name'], 'title' => $role['title'], 'description' => $role['description']]);
        }
        return true;
    }

    public function initPermissions(): bool
    {
        //清空权限表
        //如果权限表不为空，则返回错误信息
        if (Permission::count() > 0) {
//            abort(404, '权限表已存在');
            return false;
        }
        $allPermissions = config('menus');

        PermissionService::getDeepPermission($allPermissions);
        return true;
    }
}
