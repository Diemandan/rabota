<?php

namespace App\Http\Controllers;



use App\Services\StatisticService;

class StatisticController extends Controller
{
    public function __construct(protected StatisticService $service)
    {
    }

    public function index()
    {
        $totalStatistic = $this->service->getTotalInfo();

        return view('statistics/statistic', compact('totalStatistic'));
    }
}
