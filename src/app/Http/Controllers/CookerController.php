<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestOrder\RequestOrderNotGeted;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CookerRequest;
use App\Repositories\RequestOrderRepository;
use App\Transformers\RequestOrderTransformer;
use App\Types\PaginationValueTypes;
use Illuminate\Http\JsonResponse;

class CookerController extends Controller
{
    /**
     * @param CookerRequest $request
     * @return JsonResponse
     * @throws RequestOrderNotGeted
     */
    public function index(CookerRequest $request): JsonResponse
    {
        $orders = (new RequestOrderRepository())->getByUserAndTerm($request->user_id, $request->term, $request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT);

        return ResponseHelper::results((new RequestOrderTransformer())->index($orders->toArray()));
    }
}
