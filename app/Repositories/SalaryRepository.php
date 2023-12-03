<?php

namespace App\Repositories;

use App\Models\Salary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SalaryRepository
{
    protected Salary $model;

    const PER_PAGE = 10;

    public function __construct(Salary $model)
    {
        $this->model = $model;
    }

    public function totalYearSalary()
    {
        return $this->model->where('transfer_date', '>=', date('Y-01-01'))->get();
    }

    public function salariesByCadenceId(?string $id): LengthAwarePaginator|Collection
    {
        $query = $this->model->with('cadence');

        if (!is_null($id))
            return $query->where('cadence_id', $id)->get();

        return $query->latest()->paginate(self::PER_PAGE);
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

    public function findSalariesSumForCadence(int $id)
    {
        return $this->model->where('cadence_id', $id)->sum('transfer_amount');
    }


    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
