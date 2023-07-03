<?php

namespace App\Repositories;

use App\Models\Budget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BudgetRepository
{
    protected Budget $model;

    public function __construct(Budget $model)
    {
        $this->model = $model;
    }


    public function create(array $data)
    {
        $this->model->create($data);
    }

    public function update(array $data)
    {
        $model = $this->model->find($data['id']);
        $model->update($data);
    }

    public function delete(int $id)
    {
        $this->model->destroy($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @return Budget
     */
    public function getByMonth(string $month): Collection
    {
        return $this->model->where('month', $month)->get();
    }

    public function getMonths(): array
    {
        return $this->model->pluck('month')->unique()->toArray();
    }
}
