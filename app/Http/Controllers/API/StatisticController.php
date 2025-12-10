<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;

class StatisticController extends Controller
{
    private StatisticService $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function index(): JsonResponse
    {
        $totalStatistic = $this->statisticService->getTotalInfo();
        return response()->json($totalStatistic);
    }
}
