<?php

namespace App\Repositories;

use App\Models\Cadence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
        $cadence = $this->model->create($data);
        $cadence->debt()->create($data);
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

    public function getLatest()
    {
        return $this->model->with('debt', 'bonuses')->latest()->first();
    }

    public function getCadences(): LengthAwarePaginator
    {
        return $this->model->with('salaries', 'debt', 'bonuses')->paginate(self::PER_PAGE);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function cadencesList(): Collection
    {
        return $this->model->select(['id', 'start'])->latest()->get();
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
