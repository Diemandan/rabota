<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ExpenseRepository
{
    protected Expense $model;

    const PER_PAGE = 10;

    public function __construct(Expense $model)
    {
        $this->model = $model;
    }


    public function create(array $data)
    {
        $this->model->create($data);
    }

    public function getExpenseSumsForCadence(int $id): int
    {
        return $this->model->where('cadence_id', $id)->sum('payment_amount');
    }
    public function update(array $data)
    {
        $model = $this->model->find($data['id']);
        $model->update($data);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->model->with('cadence')->paginate(self::PER_PAGE);
    }
}
