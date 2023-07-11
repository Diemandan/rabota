<?php

namespace App\Http\Controllers;


use App\Services\CadenceService;
use App\Services\StatisticService;
use PDF;

class StatisticController extends Controller
{
    public function __construct(protected StatisticService $service,
                                protected CadenceService   $cadenceService)
    {
    }

    public function index()
    {
        $totalStatistic = $this->service->getTotalInfo();

        return view('statistics/statistic', compact('totalStatistic'));
    }

    public function cadencePdfReport($id)
    {
        $cadence = $this->cadenceService->getCadence($id);
        $pdf = PDF::loadView('pdf.cadencePdf', compact('cadence'));

        return $pdf->download('Paeta_otchet.pdf');
    }
}
