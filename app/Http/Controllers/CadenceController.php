<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadenceRequest;
use App\Models\Cadence;
use App\Services\CadenceService;
use Illuminate\Http\Request;

class CadenceController extends Controller
{
    private CadenceService $cadenceService;

    public function __construct(CadenceService $cadenceService)
    {
        $this->cadenceService = $cadenceService;
    }

    public function index()
    {
        $cadences = $this->cadenceService->getCadences();
        return view('cadence.index', compact('cadences'));
    }

    public function show($id)
    {
        $cadence = $this->cadenceService->getCadence($id);
        return view('cadence.show', compact($cadence));
    }

    public function create()
    {
        return view('cadence.create');
    }

    public function edit($id)
    {
        $cadence = $this->cadenceService->getCadence($id);
        return view('cadence.create', compact('cadence'));
    }

    public function store(CadenceRequest $request)
    {
        if ($request->validated()) {
            $this->cadenceService->create($request);

            return redirect()->route('cadences.index')->with('success', 'Cadence updated successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }

    public function delete($id)
    {
        $this->cadenceService->delete($id);

        return redirect()->route('cadences.index')->with('success', 'Cadence deleted successfully.');
    }
}
