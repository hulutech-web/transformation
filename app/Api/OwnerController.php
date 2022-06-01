<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Http\Resources\OwnerResource;
use App\Models\Build;
use App\Models\Owner;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //如果是超级管理员，返回全部，否则返回当前用户创建的户主
        $isAdmin = Auth::id() == 1;
        if ($isAdmin) {
            return Owner::paginate(10);
        } else {
            $user = Auth::user();
//            如果有当前用户创建的户主，返回户主，否则返回空
            return $user->owners ? $user->owners()->paginate(10) : [];
        }
    }


    public function store(StoreOwnerRequest $request, Build $build, Unit $unit)
    {
        $owner = Owner::create($request->input() + ['user_id' => Auth::id()]);
        $owner->save();
        return $this->message('添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        return $owner;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateOwnerRequest $request
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Build $build, Unit $unit, Owner $owner)
    {
        $owner->update($request->except('build_name') + ['user_id' => Auth::id()]);
        return $this->message('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Build $build, Unit $unit, Owner $owner)
    {
        $owner->delete();
        return $this->message('删除成功');
    }

    //搜索
    public function searchOwner(Request $request)
    {
        $owners = Owner::where('householder_name', 'like', '%' . $request->keyword . '%')
            ->paginate(20);
        return $owners;
    }

    //远程输入框搜索
    public function remoteOwner(Request $request)
    {
        $owners = Owner::where('householder_name', 'like', '%' . $request->keyword . '%')
            ->paginate(10);
        return $owners;
    }


    //提供前端远程搜索
    public function filterOwner(Request $request)
    {
        //资源返回，并分页
        $owners = Owner::where('householder_name', 'like', '%' . $request->keywords . '%')
            ->paginate(10);
        return OwnerResource::collection($owners);
    }
}
