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
    private CadenceService  $cadenceService;

    public function __construct(SalaryService $salaryService, CadenceRepository $cadenceRepository, CadenceService $cadenceService)
    {
        $this->salaryService = $salaryService;
        $this->cadenceRepository = $cadenceRepository;
        $this->cadenceService = $cadenceService;
    }


    public function index(Request $request)
    {
        $request->validate([
            'cadence_id' => 'integer|exists:cadences,id'
        ]);
        $cadenceId = $request->cadence_id;

        $cadencesForFilter = $this->cadenceService->getCadencesList();
        $cadencesForForm = $this->cadenceRepository->all();
        $salaries = $this->salaryService->getAll($cadenceId);

        return view('salaries.index', [
            'salaries' => $salaries,
            'cadences' => $cadencesForFilter,
            'cadencesForForm' => $cadencesForForm
        ]);
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
        $this->salaryService->create($request);
        return redirect()->back()->with('success', 'Перевод успешно добавлен.');
    }

    public function update(SalaryRequest $request, int $id)
    {
        $request->merge(['id' => $id]);
        $this->salaryService->update($request);
        return redirect()->back()->with('success', 'Перевод успешно обновлен.');
    }

    public function delete($id)
    {
        $this->salaryService->delete($id);
        return redirect()->back()->with('success', 'Перевод успешно удален.');
    }
}
