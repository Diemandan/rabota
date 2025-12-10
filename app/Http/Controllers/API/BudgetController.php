<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Services\BudgetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    private BudgetService $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    public function index(Request $request): JsonResponse
    {
        $budgets = $this->budgetService->getBudgets($request);
        $months = $this->budgetService->getMonths();
        $totalCashSum = is_iterable($budgets) ? collect($budgets)->sum('cash') : 0;

        return response()->json([
            'budgets' => $budgets,
            'months' => $months,
            'total_cash_sum' => $totalCashSum,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $budget = $this->budgetService->getBudget($id);
        return response()->json($budget);
    }

    public function store(BudgetRequest $request): JsonResponse
    {
        $this->budgetService->create($request);
        return response()->json(['message' => 'Бюджет создан успешно'], 201);
    }

    public function update(BudgetRequest $request, int $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $this->budgetService->create($request);
        return response()->json(['message' => 'Бюджет обновлен успешно']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->budgetService->delete($id);
        return response()->json(['message' => 'Бюджет удален успешно']);
    }
}
