<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Models\Debt;
use App\Repositories\cadenceRepository;
use App\Repositories\DebtRepository;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;

class DebtService
{
    protected DebtRepository $debtRepository;

    public function __construct(DebtRepository $repository)
    {
        $this->debtRepository = $repository;

    }

    public function setDebt()
    {

    }


    public function delete($id): void
    {
        $this->debtRepository->delete($id);
    }

}
