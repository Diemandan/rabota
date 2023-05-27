<?php


namespace App\Services;

use App\Http\Requests\CadenceRequest;
use App\Repositories\cadenceRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Session\Store;

class CadenceService
{
    protected $cadenceRepository;

    public function __construct(CadenceRepository $repository)
    {
        $this->cadenceRepository = $repository;

    }

    public function getCadences(): LengthAwarePaginator
    {
        return $this->cadenceRepository->getCadences();
    }


    public function getCadence($id)
    {
        return $this->cadenceRepository->find($id);
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
}
