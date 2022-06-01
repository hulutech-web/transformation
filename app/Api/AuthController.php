<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Exception;
use RuntimeException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * 帐号登录注册管理
 * @package App\Api\User
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['login']);
    }

    /**
     * 帐号登录
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'max:11', 'regex:/^1[3456789][0-9]{9}$/'],
            'password' => ['required'],
            'captcha.content' => ['sometimes', 'required', 'captcha_api:' . request('captcha.key') . ',default']
        ], [
            'mobile' => '帐号不能为空',
            'mobile.exists' => '帐号不存在',
            'password.required' => '密码不能为空',
            'captcha.content.required' => '验证码不能为空',
            'captcha.content.captcha_api' => '验证码输入错误'
        ]);

        $isLogin = Auth::attempt([
            'mobile' => $request->mobile,
            'password' => $request->password
        ]);

        if ($isLogin) {
            return ['message' => '登录成功', 'token' => $this->token(Auth::user()), 'data' => Auth::user()];
        }
        return response(['message' => '帐号或密码错误'], 405);
    }

    /**
     * 退出登录
     * @return void
     * @throws RuntimeException
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->message('帐号退出成功');
    }


    /**
     * 获取令牌
     *
     * @param User $user
     * @return void
     */
    protected function token(User $user)
    {
        return $user->createToken('auth')->plainTextToken;
    }

    /**
     * 找回密码
     *
     * @param Request $request
     * @return void
     */
    public function forget(Request $request, User $user)
    {
        $request->validate([
            'account' => ['required', new AccountRule(request('account')), Rule::exists('users', UserService::account())],
            'password' => ['required', 'confirmed', 'between:5,20'],
            'code' => ['sometimes', 'required', new CodeRule(request('account'))]
        ], [
            'account.required' => '帐号不能为空',
            'account.exists' => '帐号不存在',
            'password.required' => '密码不能为空',
            'code.required' => '验证码不能为空'
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return ['message' => '密码重置成功', 'token' => $this->token($user)];
    }
}
