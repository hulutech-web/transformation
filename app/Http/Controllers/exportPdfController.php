<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChargingReportResource;
use App\Models\CarReport;
use App\Models\ChargingReport;
use Auth;
use ConvertChargingService;
use ConvertService;
use Illuminate\Http\Request;

class exportPdfController extends Controller
{
//    转换汽車報告pdf
    public function exportpdf(CarReport $carreport)
    {
        return ConvertService::handleCarReport($carreport);
    }

//    转换充電樁報告pdf

    public function exportChargingPdf(ChargingReport $chargingreport)
    {

        $chargingResource = new ChargingReportResource($chargingreport);
        
        return ConvertChargingService::handleChargingReport($chargingResource);
    }
}
