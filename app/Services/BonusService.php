<?php


namespace App\Services;

use App\Http\Requests\BonusRequest;
use App\Http\Requests\CadenceRequest;
use App\Models\Bonus;
use App\Repositories\cadenceRepository;
use App\Repositories\BonusRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BonusService
{
    protected BonusRepository $bonusRepository;

    public function __construct(BonusRepository $repository)
    {
        $this->bonusRepository = $repository;

    }

    public function getBonusSumForCadence(int $id): int
    {
        return $this->bonusRepository->findBonusesSumForCadence($id);

    }

    public function create(BonusRequest $request)
    {
        $data = $request->all();
        $this->bonusRepository->create($data);
    }

    public function delete($id): void
    {
        $this->bonusRepository->delete($id);
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->bonusRepository->all();
    }

}
