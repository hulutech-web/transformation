<?php

namespace App\Api;

use App\Http\Controllers\Controller;

//首页控制器
class HomeController extends Controller
{
    public function index()
    {

    }

    public function bootstrap()
    {
        return '角色權限表初始化成功';
    }
}
