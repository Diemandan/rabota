<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Models\Cadence;
use App\Models\Salary;
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

    protected BonusService $bonusService;

    protected ExpenseService $expenseService;

    public function __construct(
        CadenceRepository $repository,
        SalaryService     $salaryService,
        BonusService      $bonusService,
        ExpenseService    $expenseService)
    {
        $this->cadenceRepository = $repository;
        $this->salaryService = $salaryService;
        $this->bonusService = $bonusService;
        $this->expenseService = $expenseService;


    }

    public function getCadences(): LengthAwarePaginator
    {
        $cadences = $this->cadenceRepository->getCadences();

        foreach ($cadences as $cadence) {
            $cadence['start'] = Carbon::parse($cadence['start'])->format('Y-m-d H:i');
            $cadence['finish'] = Carbon::parse($cadence['finish'])->format('Y-m-d H:i');
            $cadence->totalBalance = $this->getTotalDebt($cadence);
            $cadence->totalDays = $this->getTotalDays($cadence);
            $cadence->totalSalariesPayments = $this->salaryService->getSalariesSumByCadenceId($cadence->id);
        }

        return $cadences;
    }


    public function getCadence($id)
    {
        $cadence = $this->cadenceRepository->find($id);

        $cadence->totalAmount = $cadence->salaries->sum('transfer_amount');
        $cadence->totalBalance = $this->getTotalDebt($cadence);
        $cadence->totalDays = $this->getTotalDays($cadence);
        $cadence->startDebt = $cadence->debt->debt;

        return $cadence;
    }

    public function getCadencesList()
    {
        $cadences = $this->cadenceRepository->cadencesList();

        $cadences->map(function ($cadence) {
            $cadence->start = Carbon::parse($cadence->start)->format('Y-m-d');
            return $cadence;
        });

        return $cadences;
    }

    public function create(CadenceRequest $request): void
    {
        $data = $request->except('_token');
        $data['start'] = Carbon::parse($data['start'])->format('Y-m-d H:i');
        if (isset($data['finish']))
            $data['finish'] = Carbon::parse($data['finish'])->format('Y-m-d H:i');

        if ($request->input('id')) {
            $this->cadenceRepository->update($data);
        } else {
            $debtDate = Carbon::parse($data['start'])->subDay()->toDateString();

            $latestCadence = $this->cadenceRepository->getLatest();

            $data['debt'] = $this->getTotalDebt($latestCadence);
            $data['date'] = $debtDate;

            $this->cadenceRepository->create($data);
        }
    }

    public function delete($id): void
    {
        $this->cadenceRepository->delete($id);
    }

    public function getTotalDebt(Model $cadence): int
    {
        $salariesSum = $this->salaryService->getSalariesSumByCadenceId($cadence->id);
        $bonusSum = $this->bonusService->getBonusSumForCadence($cadence->id);
        $expensesSum = $this->expenseService->getExpenseSumForCadence($cadence->id);
        $days = $this->getTotalDays($cadence);

        $totalBalance = ($days * $cadence->daily_rate + $cadence->debt->debt + $bonusSum + $expensesSum) - $salariesSum;

        return $totalBalance;
    }

    private function getTotalDays(Model $cadence): int|float
    {
        $startDate = Carbon::parse($cadence->start, 2)->startOfDay();
        $endDate = Carbon::parse($cadence->finish, 2)->startOfDay();

        $days = $endDate->diffInDays($startDate) + 1; // Add 1 for the current day
        return $days;
    }
}
