<?php

use App\Api\AuthController;
use App\Api\BuildController;
use App\Api\CaptchaController;
use App\Api\ContractController;
use App\Api\ContractRecordController;
use App\Api\HomeController;
use App\Api\MenuController;
use App\Api\OwnerController;
use App\Api\PermissionController;
use App\Api\RoleController;
use App\Api\UnitController;
use App\Api\UploadController;
use App\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('admin/user/login', [AuthController::class, 'login']);
Route::post('admin/user/logout', [AuthController::class, 'logout']);

Route::post('admin/user/info', [UserController::class, 'info']);

//图形验证码
Route::get('captcha', [CaptchaController::class, 'make']);
//-----------------------后台路由-----------------------
Route::group(['middleware' => ['auth:sanctum']], function () {
    //全局菜单

    Route::post("admin/menus", [MenuController::class, 'generateMenus']);

    Route::post('menu/list', [MenuController::class, 'menuList']);

    Route::post('user/getMenus', [MenuController::class, 'getMenus']);
    //    角色
    Route::post('admin/role/init', [RoleController::class, 'init']);
    Route::apiResource('admin/role', RoleController::class);
    Route::post('admin/user/{user}/role', [RoleController::class, 'getRole']);
    Route::post('admin/user/{user}/setRole', [RoleController::class, 'setRole']);
    //    权限（菜单）
    Route::post("admin/permission/init", [PermissionController::class, 'initPermissions']);
    Route::post('admin/role/{role}/syncpermissions', [PermissionController::class, 'syncPermissions']);
    Route::post("admin/role/{role}/permissions", [PermissionController::class, "getPermissions"]);
    Route::post('admin/defaultPermission', [PermissionController::class, 'getDefaultPermission']);
    Route::post('admin/user/permissions', [PermissionController::class, 'getUserPermissions']);
    //    用户
    Route::get('user', [UserController::class, 'index']);
    Route::get('admin/user/{user}', [UserController::class, 'show']);
    Route::post('user', [UserController::class, 'store']);
    Route::get('user/{user}', [UserController::class, 'edit']);
    Route::put('user/{user}', [UserController::class, 'update']);
    Route::delete('user/{user}', [UserController::class, 'destroy']);
    Route::post('user/search', [UserController::class, 'searchUser']);


    Route::post('upload/image', [UploadController::class, 'uploadImage']);
    //楼盘信息
    Route::post('admin/build', [BuildController::class, 'store']);
    Route::get('admin/build', [BuildController::class, 'index']);
    Route::get('admin/build/{build}', [BuildController::class, 'show']);
    Route::put('admin/build/{build}', [BuildController::class, 'update']);

    Route::delete('admin/build/{build}', [BuildController::class, 'destroy']);
    //搜索
    Route::post("admin/build/search", [BuildController::class, 'searchBuild']);
    Route::post('admin/build/list', [BuildController::class, 'list']);

    //楼盘单元
    Route::post("admin/build/{build}/unit", [UnitController::class, 'store']);
    Route::get("admin/build/{build}/unit", [UnitController::class, 'index']);
    Route::put("admin/build/{build}/unit/{unit}", [UnitController::class, 'update']);
    Route::delete("admin/build/{build}/unit/{unit}", [UnitController::class, 'destroy']);
    //住户
    Route::post('admin/build/{build}/unit/{unit}/owner', [OwnerController::class, 'store']);
    Route::delete('admin/build/{build}/unit/{unit}/owner/{owner}', [OwnerController::class, 'destroy']);
    Route::put('admin/build/{build}/unit/{unit}/owner/{owner}', [OwnerController::class, 'update']);

    Route::get("admin/owner", [OwnerController::class, 'index']);

    Route::get('admin/owner/{owner}', [OwnerController::class, 'show']);
    Route::post("admin/owner/searchOwner", [OwnerController::class, 'searchOwner']);
//提供前端远程搜索
    Route::post("admin/owner/filterOwner", [OwnerController::class, 'filterOwner']);

    //远程输入框搜索
    Route::post("admin/owner/remoteOwner", [OwnerController::class, 'remoteOwner']);

    //合同【获取条形码】
    Route::post('admin/contract/getCode', [ContractController::class, 'getCode']);
    //获取UUID值
    Route::post('admin/contract/getUuid', [ContractController::class, 'getUuid']);

    //合同预览图

    Route::post('admin/contract/{contract}/preview', [ContractController::class, 'getPreviewContract']);

    Route::apiResource('admin/contract', ContractController::class);
    //获取业务员的合同列表
    Route::post('admin/user/{user}/contract/getUserContract', [ContractController::class, 'getUserContract']);
    //关键字搜索
    Route::post('admin/user/{user}/contract/getOwnerContract', [ContractController::class, 'getOwnerContract']);
//    财务可查合同
    Route::post("admin/contract/finance", [ContractController::class, 'getFinancialContract']);
//    财务缴费
    Route::post("admin/contract/{contract}/putFinancialPayment", [ContractController::class, 'putFinancialPayment']);

    //查询缴费历史

    Route::post('admin/FinancialHistory', [ContractRecordController::class, 'queryHistory']);
    Route::post('admin/contractrecord/allhistory', [ContractRecordController::class,'allhistory']);
    //首页汇总

    Route::post("admin/home", [HomeController::class, 'index']);
});

//-----------------------后台路由END-----------------------

//-----------------------前台路由-----------------------
Route::group(['prefix' => 'front/'], function () {
    //登录
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('user/info', [UserController::class, 'info']);

    //验证码
    Route::get('captcha', [CaptchaController::class, 'make']);
});
//-----------------------前台路由END-----------------------
