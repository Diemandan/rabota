<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Http\Requests\SalaryRequest;
use App\Models\Salary;
use App\Repositories\cadenceRepository;
use App\Repositories\SalaryRepository;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;

class SalaryService
{
    protected SalaryRepository $salaryRepository;

    public function __construct(SalaryRepository $repository)
    {
        $this->salaryRepository = $repository;

    }

    public function getSalariesSumByCadenceId(int $id): int
    {
        return $this->salaryRepository->findSalariesSumForCadence($id);
    }

    public function getAll(?string $id = NULL): LengthAwarePaginator|Collection
    {
        return $this->salaryRepository->salariesByCadenceId($id);
    }

    public function create(SalaryRequest $request): void
    {
        $data = $request->except('_token');

            $this->salaryRepository->create($data);

    }

    public function delete($id): void
    {
        $this->salaryRepository->delete($id);
    }

}
