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

    public function getBudgets($request): Model|Collection
    {
        if ($request->has('all'))
            return $this->repository->getAllMonthes();

        if ($request->month)
            return $this->repository->getByMonth($request->month);

        return $this->repository->getCurrent();
    }

    public function getMonths(): array
    {
        return $this->repository->getMonths();
    }

    public function create(BudgetRequest $request): void
    {
        $data = $request->except('_token');

        if ($request->input('id')) {
            $this->repository->update($data);
        } else {
            $this->repository->create($data);
        }
    }

    public function getBudget($id)
    {
        $budget = $this->repository->find($id);

        return $budget;
    }
}
