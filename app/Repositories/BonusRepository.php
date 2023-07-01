<?php

namespace App\Repositories;

use App\Models\Bonus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BonusRepository
{
    protected Bonus $model;

    const PER_PAGE = 10;

    public function __construct(Bonus $model)
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

    public function findBonusesSumForCadence(int $id): int
    {
        return $this->model->where('cadence_id', $id)->sum('transfer_amount');
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function all(): LengthAwarePaginator
    {
        return $this->model->with('cadence')->paginate(self::PER_PAGE);
    }
}
