<?php

namespace App\Repositories;

use App\Models\Debt;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class DebtRepository
{
    protected Debt $model;

    const PER_PAGE = 10;

    public function __construct(Debt $model)
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
        return $this->model->with('salaries', 'debt')->find($id);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
