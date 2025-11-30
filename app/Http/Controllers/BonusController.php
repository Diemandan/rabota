<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonusRequest;
use App\Repositories\CadenceRepository;
use App\Services\BonusService;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public BonusService $bonusService;
    public CadenceRepository $cadenceRepository;

    public function __construct(BonusService $bonusService, CadenceRepository $cadenceRepository)
    {
        $this->cadenceRepository = $cadenceRepository;
        $this->bonusService = $bonusService;
    }

    public function index()
    {
        $bonuses = $this->bonusService->getAll();
        return view('bonuses.index', compact('bonuses'));
    }

    public function create()
    {
        $cadences = $this->cadenceRepository->getCadences();
        return view('bonuses.create', compact('cadences'));
    }

    public function store(BonusRequest $request)
    {
        $this->bonusService->create($request);
        return redirect()->route('bonuses.index')->with('success', 'Корректировка успешно добавлена.');
    }

    public function update(BonusRequest $request, int $id)
    {
        $request->merge(['id' => $id]);
        $this->bonusService->update($request);
        return redirect()->route('bonuses.index')->with('success', 'Корректировка успешно обновлена.');
    }

    public function delete($id)
    {
        $this->bonusService->delete($id);
        return redirect()->route('bonuses.index')->with('success', 'Корректировка успешно удалена.');
    }

}
