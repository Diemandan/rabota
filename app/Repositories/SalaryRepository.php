<?php

namespace App\Repositories;

use App\Models\Salary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class SalaryRepository
{
    protected Salary $model;

    const PER_PAGE = 10;

    public function __construct(Salary $model)
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

    public function find($id): Model
    {
        return $this->model->with('cadence')->find($id);
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
