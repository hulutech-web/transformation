<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * 角色管理
 * @package App\Http\Controllers\Site
 */
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }


    public function init()
    {
        $roles = config('roles');
        if (Role::all()->count() > 0) {
            return $this->error('角色成功已初始化，无需重复初始化');
        }
        foreach ($roles as $role) {
            Role::create(['name' => $role['name'], 'title' => $role['title'], 'description' => $role['description']]);
        }
        return $this->message('初始化角色成功');
    }

    /**
     * 角色列表
     * @param Site $site
     * @return void
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * 角色列表
     * @param Site $site
     * @param Role $role
     * @return void
     */
    public
    function show(Request $request, Role $role)
    {
        return $role;
    }

    /**
     * 保存角色
     * @param RoleRequest $request
     * @param Site $site
     * @return void
     */
    public
    function store(Request $request)
    {
        $role = Role::create($request->only(['title', 'name']));
        return $this->message('角色添加成功', $role);
    }

    /**
     * 更新角色
     * @param RoleRequest $request
     * @param Site $site
     * @param Role $role
     * @return void
     */
    public
    function update(Request $request, Role $role)
    {
        $role->fill($request->input())->save();
        return $this->message('角色修改成功');
    }

    /**
     * 删除角色
     * @param Site $site
     * @param Role $role
     * @return void
     */
    public
    function destroy(Site $site, Role $role)
    {
        $role->delete();
        return $this->message('角色删除成功');
    }

    public function getRole(Request $request, User $user, Role $role)
    {
        //获取用户角色
        $roles = $user->roles()->first();
        if (isset($roles)) {
            return $roles;
        } else {
            return $this->error('用户没有角色,请联系管理员');
        }
    }

    public function setRole(Request $request, User $user)
    {
        //更新用户角色
        $user->syncRoles($request->input());

//        $user->assignRole($request->role);
        return $this->message('角色设置成功');
    }


}
