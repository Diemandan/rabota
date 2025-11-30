<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Repositories\CadenceRepository;
use App\Repositories\SalaryRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatisticService
{
    public function __construct(
       protected CadenceRepository $cadenceRepository,
       protected SalaryRepository $salaryRepository,
       protected SalaryService $salaryService,
       protected BonusService $bonusService,
       protected ExpenseService $expenseService)
    {
    }


    public function getTotalInfo(): array
    {
        $yearSalary = $this->salaryRepository->totalYearSalary()->sum('transfer_amount');
        $lastYearSalary = $this->salaryRepository->totalLastYearSalary()->sum('transfer_amount');
        $totalLastYearDays = 365;
        $totalDays = Carbon::now()->isoFormat('DDD');

        return [
            'totalSalary' => $yearSalary,
            'totalDays' => $totalDays,
            'lastYearSalary' => $lastYearSalary,
            'totalLastYearDays' => $totalLastYearDays,
        ];
    }

    public function create(CadenceRequest $request): void
    {
        $data = $request->except('_token');

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

    public function delete(int $id): void
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

    private function getTotalDays(Model $cadence): int
    {
        $startDate = Carbon::parse($cadence->start, 2)->startOfDay();
        $endDate = $cadence->finish 
            ? Carbon::parse($cadence->finish, 2)->startOfDay() 
            : Carbon::now(2)->startOfDay();

        $days = $endDate->diffInDays($startDate) + 1;

        return $days;
    }
}
