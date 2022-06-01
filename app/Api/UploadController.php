<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use UploadService;
class UploadController extends Controller
{
    //xlsx文件上传
    public function upload(Request $request)
    {
        $request->validate(['file' => ['required', 'mimes:jpeg,png,mp3,mp4,xls,xlsx', 'max:20000']]);
        return UploadService::local($request->file);
    }
//图片上传
    public function uploadImage(Request $request)
    {
        $request->validate(['file' => ['required', 'mimes:jpeg,png,mp3,mp4', 'max:20000']]);
        $image = UploadService::localImage($request->file);
        return $this->message('上传成功', ['image' => $image]);
    }
}
