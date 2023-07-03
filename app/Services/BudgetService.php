<?php


namespace App\Services;

use App\Http\Requests\BonusRequest;
use App\Http\Requests\BudgetRequest;
use App\Http\Requests\CadenceRequest;
use App\Models\Bonus;
use App\Repositories\BudgetRepository;
use App\Repositories\cadenceRepository;
use App\Repositories\BonusRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetService
{
    public function __construct(protected BudgetRepository $repository)
    {
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function getBudgets(?string $month): Model|Collection
    {
        if (!$month)
            return $this->repository->all();

        return $this->repository->getByMonth($month);
    }

    public function getMonths(): array
    {
        return $this->repository->getMonths();
    }

    public function create(BudgetRequest $request): void
    {
        $data = $request->except('_token');

        $this->repository->create($data);
    }
}
