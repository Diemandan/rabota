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
        if ($request->validated()) {
            $this->bonusService->create($request);

            return redirect()->route('bonuses.index')->with('success', 'Payment added successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }

    public function delete($id)
    {
        $this->bonusService->delete($id);
        return redirect()->route('bonuses.index')->with('success', 'Payment deleted successfully.');
    }

}
