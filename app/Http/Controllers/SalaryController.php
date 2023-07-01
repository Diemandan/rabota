<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRequest;
use App\Models\Cadence;
use App\Models\Salary;
use App\Repositories\CadenceRepository;
use App\Services\CadenceService;
use App\Services\SalaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalaryController extends Controller
{

    private SalaryService $salaryService;
    private CadenceRepository $cadenceRepository;

    public function __construct(SalaryService $salaryService, CadenceRepository $cadenceRepository)
    {
        $this->salaryService = $salaryService;
        $this->cadenceRepository = $cadenceRepository;
    }


    public function index(Request $request)
    {
        $cadenceId = $request->cadence_id;
        
        $cadences = $this->cadenceRepository->getCadences();
        $salaries = $this->salaryService->getAll($cadenceId);

        return view('salaries.index', compact('salaries', 'cadences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cadences = $this->cadenceRepository->all();

        return view('salaries.create', compact('cadences'));
    }

    public function store(SalaryRequest $request)
    {
        if ($request->validated()) {
            $this->salaryService->create($request);

            return redirect()->route('salary.index')->with('success', 'Salary added successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }

    public function delete($id)
    {
        $this->salaryService->delete($id);
        return redirect()->route('bonuses.index')->with('success', 'Payment deleted successfully.');
    }


}
