<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRequest;
use App\Services\BudgetService;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct(protected BudgetService $service)
    {
    }

    public function index(Request $request)
    {
        $months = $this->service->getMonths();
        $budgets = $this->service->getBudgets($request);
        $totalCashSum = $budgets->sum('cash');

        return view('budget.index', compact('budgets', 'months', 'totalCashSum'));
    }

    public function create()
    {
        return view('budget.create');
    }

    public function edit($id)
    {
        $budget = $this->service->getBudget($id);
        return view('budget.create', compact('budget'));
    }

    public function store(BudgetRequest $request)
    {
        if ($request->validated()) {
            $this->service->create($request);

            return redirect()->route('budget.index')->with('success', 'Expense added successfully.');
        }

        return redirect()->back()->withErrors($request->errors())->withInput();
    }

    public function delete(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('budget.index')->with('success', 'Payment deleted successfully.');

    }
}
