<?php

namespace App\Repositories;

use App\Models\Cadence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CadenceRepository
{
    protected Cadence $model;

    const PER_PAGE = 10;

    public function __construct(Cadence $model)
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

    public function find($id): Cadence
    {
        return $this->model->find($id);
    }

    public function getCadences(): LengthAwarePaginator
    {
        return $this->model->paginate(self::PER_PAGE);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
