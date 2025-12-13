<?php


namespace App\Services;

use App\Http\Requests\ExpenseRequest;
use App\Repositories\ExpenseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseService
{
    protected ExpenseRepository $expenseRepository;

    public function __construct(ExpenseRepository $repository)
    {
        $this->expenseRepository = $repository;

    }

    public function getExpenseSumForCadence(int $id): int
    {
        return $this->expenseRepository->getExpenseSumsForCadence($id);

    }

    public function delete($id): void
    {
        $this->expenseRepository->delete($id);
    }

    public function getExpenses(?int $id = null): LengthAwarePaginator
    {
        return $id ? $this->expenseRepository->getByCadence($id) : $this->expenseRepository->getAll();
    }

    public function create(ExpenseRequest $request): void
    {
        $data = $request->except('_token');

        $this->expenseRepository->create($data);
    }

    public function update(ExpenseRequest $request): void
    {
        $data = $request->except('_token');
        $this->expenseRepository->update($data);
    }

    public function find(int $id)
    {
        return $this->expenseRepository->find($id);
    }

}
