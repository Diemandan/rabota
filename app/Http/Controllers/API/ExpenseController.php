<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    private ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index(): JsonResponse
    {
        $cadenceId = request()->input('Cadence_id');
        $expenses = $this->expenseService->getExpenses($cadenceId ? (int) $cadenceId : null);

        return response()->json($expenses);
    }

    public function show(int $id): JsonResponse
    {
        $expense = $this->expenseService->find($id);
        return response()->json($expense);
    }

    public function store(ExpenseRequest $request): JsonResponse
    {
        $this->expenseService->create($request);
        return response()->json(['message' => 'Расход создан успешно'], 201);
    }

    public function update(ExpenseRequest $request, int $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $this->expenseService->update($request);
        return response()->json(['message' => 'Расход обновлен успешно']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->expenseService->delete($id);
        return response()->json(['message' => 'Расход удален успешно']);
    }
}
