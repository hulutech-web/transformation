<?php

namespace App\Services\ModifyDoc;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * 修改文档服务
 * @package App\Services
 */
class ModifyDocService
{
    public function init($id, $uuid)
    {
        $PHPWord = new PhpWord();
        //指定事先制作好的模板文件路径
        $templateProcessor = new TemplateProcessor(public_path("doc/代理服务合同2.0.docx"));
//        $templateProcessor->setValue('project', $uuid);

        //在project位置放一张图片
        $this->generateBarCode($id, $uuid);
        $templateProcessor->setImageValue('project', array('path' => public_path('contract/barcode'.$id.'.png'), 'width' => 400, 'height' => 30, 'ratio' => false));
        //保存新word文档
        $path = md5(time());
        if (!is_dir(public_path("doc/output"))) {
            mkdir(public_path("doc/output"), 0755, true);
        }

        $templateProcessor->saveAs(public_path("doc/output/".$id.".docx"));
        //删除文件
        unlink(public_path("contract/barcode".$id.".png"));
    }

//返回一个文件路径
    public function generateBarCode($id, $uuid)
    {
        $color = [0, 0, 0];
        $generator = new BarcodeGeneratorPNG();
        if (!is_dir(public_path("contract"))) {
            mkdir(public_path("contract"), 0755, true);
        }
        file_put_contents('contract/barcode'.$id.'.png', $generator->getBarcode($uuid, $generator::TYPE_CODE_128, 8, 50, $color));
    }
}
