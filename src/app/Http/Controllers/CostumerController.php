<?php

namespace App\Http\Controllers;

use App\Core\Document;
use App\Core\Person\Costumer;
use App\Exceptions\Costumer\CostumerNotStored;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CostumerRequest;
use App\Repositories\{
    CostumerRepository,
    Repository,
};
use Illuminate\Http\JsonResponse;

class CostumerController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new CostumerRepository();
    }

    /**
     * @param CostumerRequest $request
     * @return JsonResponse
     * @throws CostumerNotStored
     */
    public function store(CostumerRequest $request): JsonResponse
    {
        $document = new Document($request->document['type'], $request->document['value']);

        $costumer = new Costumer($request->first_name, $request->last_name, $document, $request->email);

        $model = $this->repository->store($costumer);

        return ResponseHelper::created(['id' => $model->id]);
    }
}
