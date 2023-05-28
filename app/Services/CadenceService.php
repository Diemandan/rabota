<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Repositories\cadenceRepository;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;

class CadenceService
{
    protected cadenceRepository $cadenceRepository;

    protected SalaryService $salaryService;

    public function __construct(CadenceRepository $repository, SalaryService $salaryService)
    {
        $this->cadenceRepository = $repository;
        $this->salaryService = $salaryService;

    }

    public function getCadences(): LengthAwarePaginator
    {
        $cadences = $this->cadenceRepository->getCadences();

        foreach ($cadences as $cadence) {
            $cadence->totalBalance = $this->getTotalBalance($cadence);
        }

        return $cadences;
    }


    public function getCadence($id)
    {
        $cadence = $this->cadenceRepository->find($id);
        $totalSalary = 0;
        foreach ($cadence->salaries as $salary) {
            $totalSalary += $salary->transfer_amount;
        }
        $cadence->totalAmount = $totalSalary;
        $cadence->totalBalance = $this->getTotalBalance($cadence);


        return $cadence;
    }

    public function create(CadenceRequest $request): void
    {
        $data = $request->except('_token');

        if ($request->input('id')) {
            $this->cadenceRepository->update($data);
        } else {
            $this->cadenceRepository->create($data);
        }
    }

    public function delete($id): void
    {
        $this->cadenceRepository->delete($id);
    }

    public function getTotalBalance(Model $cadence): int
    {

        $salariesSum = $this->salaryService->getSalariesSumByCadenceId($cadence->id);

        $startDate = Carbon::parse($cadence->start);
        $endDate = Carbon::parse($cadence->finish);

        $days = $endDate->diffInDays($startDate) + 1;
        $totalBalance = ($days * $cadence->daily_rate) - $salariesSum;

        return $totalBalance;
    }
}
