<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadenceRequest;
use App\Services\CadenceService;

class CadenceController extends Controller
{
    private CadenceService $cadenceService;

    public function __construct(CadenceService $cadenceService)
    {
        $this->cadenceService = $cadenceService;
    }

    public function index(): \Illuminate\Contracts\View\View
    {
        $cadences = $this->cadenceService->getCadences();
        return view('cadence.index', compact('cadences'));
    }

    public function show(int $id): \Illuminate\Contracts\View\View
    {
        $cadence = $this->cadenceService->getCadence($id);
        return view('cadence.show', compact('cadence'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('cadence.create');
    }

    public function edit(int $id): \Illuminate\Contracts\View\View
    {
        $cadence = $this->cadenceService->getCadence($id);
        return view('cadence.create', compact('cadence'));
    }

    public function store(CadenceRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->cadenceService->create($request);

        return redirect()->route('cadences.index')->with('success', 'Cadence updated successfully.');
    }

    public function delete(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->cadenceService->delete($id);

        return redirect()->route('cadences.index')->with('success', 'Cadence deleted successfully.');
    }
}
