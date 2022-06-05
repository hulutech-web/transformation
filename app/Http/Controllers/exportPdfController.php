<?php

namespace App\Http\Controllers;

use App\Models\CarReport;
use Auth;
use ConvertService;

class exportPdfController extends Controller
{
//    转换pdf
    public function exportpdf(CarReport $carreport)
    {
        return ConvertService::handleCarReport($carreport);
    }

}
