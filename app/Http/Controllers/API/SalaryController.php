<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Services\SalaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private SalaryService $salaryService;

    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'cadence_id' => 'nullable|integer|exists:cadences,id'
        ]);
        $cadenceId = $request->cadence_id;
        $salaries = $this->salaryService->getAll($cadenceId);
        return response()->json($salaries);
    }

    public function show(int $id): JsonResponse
    {
        $salary = $this->salaryService->find($id);
        return response()->json($salary);
    }

    public function store(SalaryRequest $request): JsonResponse
    {
        $this->salaryService->create($request);
        return response()->json(['message' => 'Перевод создан успешно'], 201);
    }

    public function update(SalaryRequest $request, int $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $this->salaryService->update($request);
        return response()->json(['message' => 'Перевод обновлен успешно']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->salaryService->delete($id);
        return response()->json(['message' => 'Перевод удален успешно']);
    }
}
