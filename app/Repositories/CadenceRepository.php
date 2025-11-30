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


    public function create(array $data): void
    {
        $cadence = $this->model->create($data);
        $cadence->debt()->create($data);
    }

    public function update(array $data): void
    {
        $model = $this->model->find($data['id']);
        $model->update($data);
    }

    public function find(int $id): Model
    {
        return $this->model->with('salaries', 'debt')->find($id);
    }

    public function getLatest(): ?Model
    {
        return $this->model->with('debt', 'bonuses')->latest()->first();
    }

    public function getCadences(): LengthAwarePaginator
    {
        return $this->model->with('salaries', 'debt', 'bonuses')->orderByDesc('created_at')->paginate(self::PER_PAGE);
    }

    public function all(): Collection
    {
        return $this->model->orderByDesc('start')->get();
    }

    public function cadencesList(): Collection
    {
        return $this->model->select(['id', 'start'])->latest()->get();
    }

    public function delete(int $id): void
    {
        $this->model->destroy($id);
    }
}
