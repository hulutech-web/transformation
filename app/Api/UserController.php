<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function info()
    {
        return Auth::user();
    }

    public function show(User $user)
    {
        return $user;

    }

    public function index()
    {
        return User::paginate(10);
    }

    public function edit(Request $request, User $user)
    {
//        连同密码一起返回
        return $user->makeVisible('password');
    }

    public function store(Request $request)
    {
        //验证密码
        $this->validate($request, [
            'mobile' => Rule::unique('users', 'mobile'),
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $user = User::create($request->input());
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->message('创建成功');
    }


    public function update(Request $request, User $user)
    {
        //验证密码
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        $user->update($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->message('更新成功');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->message('删除成功');
    }


    public function searchUser(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->keyword . '%')
            ->paginate(10);
        return $users;
    }

}
