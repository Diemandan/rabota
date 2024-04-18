<?php

namespace App\Repositories;

use App\Models\Budget;
use Carbon\Carbon;
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

    public function find($id): Model
    {
        return $this->model->find($id);
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

    public function getCurrent(): Collection
    {
        return $this->model->where('month', '>=', Carbon::now()->format('Y-m'))->get();
    }

    public function getAllMonthes(): Collection
    {
        return $this->model->orderBy('month', 'DESC')->get();
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
        return $this->model->orderBy('month', 'DESC')->pluck('month')->unique()->toArray();
    }
}
