<?php

namespace App\Services\Upload;

use Auth;
use Illuminate\Http\UploadedFile;
use OSS\OssClient;
use App\Models\Attachment;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use OSS\Core\OssException;

/**
 * 文件上传
 * @package App\Services
 */
class UploadService
{

    /**
     * 本地上传
     * @param UploadedFile $file
     * @return Attachment
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function local($file)
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store(date('Ym'), 'file');
            return $this->save(url("/files/{$path}"), $file->getsize(), $file->getClientOriginalName(), $file->extension(), 'local');
        } else if (is_file($file)) {
            $info = pathinfo($file);
            $to = 'files/' . date('Ym') . '/' . date('hms') . '.' . $info['extension'];
            copy($file, public_path($to));
            return $this->save(url($to), filesize($file), basename($to), $info['extension'], 'local');
        }
    }

    /**
     * @param $file
     * @return mixed
     */
    public function localImage($file)
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store(date('Ym'), 'attachment');
            return $this->save(url("/attachments/{$path}"), $file->getsize(), $file->getClientOriginalName(), $file->extension(), 'local');
        } else if (is_file($file)) {
            $info = pathinfo($file);
            $to = 'attachments/' . date('Ym') . '/' . Auth::id() . date('his') . '.' . $info['extension'];
            copy($file, public_path($to));
            return $this->save(url($to), filesize($file), basename($to), $info['extension'], 'local');
        }
    }

    /**
     * 保存入库
     * @param mixed $path 文件链接
     * @param mixed $size 文件大小
     * @param mixed $name 源文件名
     * @param string|null $type 上传方式
     */
    protected function save($path, $size, $name = null, $extension = null, string $type = null)
    {
        return Attachment::create([
            'path' => $path,
            'user_id' => Auth::id() ? Auth::id() : 0,
            'size' => $size,
            'type' => $type,
            'name' => $name,
            'extension' => $extension
        ]);
    }

    /**
     * 删除文件
     * @param string $path
     * @return void
     */
    public function delete(?string $path)
    {
        $attachment = Attachment::where('path', $path)->first();
        if ($attachment) {
            //todo 删除oss
            $attachment->delete();
        }
    }
}
