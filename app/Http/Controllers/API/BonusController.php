<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BonusRequest;
use App\Services\BonusService;
use Illuminate\Http\JsonResponse;

class BonusController extends Controller
{
    private BonusService $bonusService;

    public function __construct(BonusService $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    public function index(): JsonResponse
    {
        $bonuses = $this->bonusService->getAll();
        return response()->json($bonuses);
    }

    public function show(int $id): JsonResponse
    {
        $bonus = $this->bonusService->find($id);
        return response()->json($bonus);
    }

    public function store(BonusRequest $request): JsonResponse
    {
        $this->bonusService->create($request);
        return response()->json(['message' => 'Бонус создан успешно'], 201);
    }

    public function update(BonusRequest $request, int $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $this->bonusService->update($request);
        return response()->json(['message' => 'Бонус обновлен успешно']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->bonusService->delete($id);
        return response()->json(['message' => 'Бонус удален успешно']);
    }
}
