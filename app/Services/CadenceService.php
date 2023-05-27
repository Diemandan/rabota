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

    public function create(CadenceRequest $request): void
    {
        $data = $request->except('_token');
        if ($request->input('id') === 0) {
            $this->cadenceRepository->create($data);
        } else {
            $this->cadenceRepository->update($data);
        }
    }

    public function delete($id): void
    {
        $this->cadenceRepository->delete($id);
    }
}
