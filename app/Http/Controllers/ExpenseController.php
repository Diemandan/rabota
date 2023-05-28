<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Repositories\CadenceRepository;
use App\Repositories\ExpenseRepository;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{

    private ExpenseService $expenseService;

    private CadenceRepository $cadenceRepository;

    public function __construct(ExpenseService $expenseService, CadenceRepository $cadenceRepository)
    {
        $this->expenseService = $expenseService;
        $this->cadenceRepository = $cadenceRepository;
    }

    public function index()
    {
        $expenses = $this->expenseService->getExpenses();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $cadences = $this->cadenceRepository->getCadences();
        return view('expenses.create', compact('cadences'));
    }

    public function store(ExpenseRequest $request)
    {
        if ($request->validated()) {
            $this->expenseService->create($request);

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }
}
