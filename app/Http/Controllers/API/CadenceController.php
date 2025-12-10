<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CadenceRequest;
use App\Services\CadenceService;
use Illuminate\Http\JsonResponse;

class CadenceController extends Controller
{
    private CadenceService $cadenceService;

    public function __construct(CadenceService $cadenceService)
    {
        $this->cadenceService = $cadenceService;
    }

    public function index(): JsonResponse
    {
        $cadences = $this->cadenceService->getCadences();
        return response()->json($cadences);
    }

    public function show(int $id): JsonResponse
    {
        $cadence = $this->cadenceService->getCadence($id);
        return response()->json($cadence);
    }

    public function store(CadenceRequest $request): JsonResponse
    {
        $this->cadenceService->create($request);
        return response()->json(['message' => 'Каденция создана успешно'], 201);
    }

    public function update(CadenceRequest $request, int $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $this->cadenceService->create($request);
        return response()->json(['message' => 'Каденция обновлена успешно']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cadenceService->delete($id);
        return response()->json(['message' => 'Каденция удалена успешно']);
    }
}
