<?php

namespace App\Services\BarCode;

use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * 条形码生成服务
 * @package App\Services
 */
class BarCodeService
{
    public function generateCode($uuid)
    {
//返回PNG格式的图片
        $generator = new BarcodeGeneratorPNG();
        //转成base64格式
        return base64_encode($generator->getBarcode($uuid, $generator::TYPE_CODE_128));
    }
}
