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
        $this->expenseService->create($request);
        return redirect()->route('expenses.index')->with('success', 'Покупка успешно добавлена.');
    }

    public function update(ExpenseRequest $request, int $id)
    {
        $request->merge(['id' => $id]);
        $this->expenseService->update($request);
        return redirect()->route('expenses.index')->with('success', 'Покупка успешно обновлена.');
    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        $this->expenseService->delete($id);
        return redirect()->route('expenses.index')->with('success', 'Покупка успешно удалена.');
    }
}
