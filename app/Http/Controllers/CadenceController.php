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

    public function create()
    {
        $cadences = $this->cadenceService->getCadences();

        return view('cadence.create', compact('cadences'));
    }

    public function store(CadenceRequest $request)
    {
        if ($request->validated()) {
            $this->cadenceService->create($request);

            return redirect()->route('home')->with('success', 'Cadence updated successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }

    public function delete($id)
    {
        $this->cadenceService->delete($id);

        return redirect()->route('cadences.index')->with('success', 'Cadence deleted successfully.');
    }
}
