<?php

use App\Api\AuthController;
use App\Api\CaptchaController;
use App\Api\CarReportController;
use App\Api\CarReportItemController;
use App\Api\ChargingPileController;
use App\Api\ChargingReportFieldController;
use App\Api\HomeController;
use App\Api\MenuController;
use App\Api\ModifyExcelController;
use App\Api\ParkController;
use App\Api\PermissionController;
use App\Api\RoleController;
use App\Api\StallController;
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

    //获取UUID值
    Route::post("admin/home", [HomeController::class, 'index']);
    Route::post("admin/home/bootstrap", [HomeController::class, 'bootstrap'])->middleware(['system']);
    //测试excel
    Route::post('admin/excel/test', [ModifyExcelController::class, 'testExcel']);
    // 汽車報告選項
    Route::post('admin/caritem/fieldinit', [CarReportItemController::class, 'init']);
    Route::get('admin/caritem/index', [CarReportItemController::class, 'index']);
    // 汽車報告
    Route::apiResource('admin/carreport', CarReportController::class);

    //生成PDF
    Route::post("admin/carreport/{carreport}/export", [CarReportController::class, 'export']);
    //转换pdf
    Route::post("admin/carreport/exportpdf", [CarReportController::class, 'exportpdf']);


//  停车场
    Route::apiResource('admin/park', ParkController::class);
//遠程搜索(停車場)
    Route::post('admin/park/search', [ParkController::class, 'searchPark']);
//停車場模板EXCEL批量導入
    Route::post('import/park', [ParkController::class, 'import']);
    Route::apiResource('admin/park/{path}/stall', StallController::class);
//    批量添加停車位
    Route::post("admin/park/stall/batch", [StallController::class, 'batch']);
    Route::get('admin/stall', [StallController::class, 'index']);
    Route::delete('admin/stall/{stall}', [StallController::class, 'destroy']);
    //    停車位模板EXCEL批量導入
    Route::post('import/stall', [StallController::class, 'import']);

    //通過park獲取stall
    Route::post('admin/park/{park}/getstallbypark', [StallController::class, 'getStallByPark']);

//    初始化充电桩字段
    Route::post('admin/chargingreportfield/init', [ChargingReportFieldController::class, 'init']);
    Route::post('admin/chargingreportfield/reset', [ChargingReportFieldController::class, 'reset']);
    Route::post('admin/chargingreportfield/getAllFields', [ChargingReportFieldController::class, 'getAllFields']);
    //    充電樁模板EXCEL批量導入

    Route::get('admin/chargingpile', [ChargingPileController::class, 'index']);
    Route::delete('admin/chargingpile/{chargingpile}', [ChargingPileController::class, 'destroy']);
    Route::post('admin/chargingpile/store', [ChargingPileController::class, 'store']);
    Route::post('import/chargingpile', [ChargingPileController::class, 'import']);
//根据stall_id获取到充電樁
    Route::get('admin/stall/{stall}/getchargingpilebystall', [ChargingPileController::class, 'getChargingPileByStall']);

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
