<?php

namespace App\Http\Controllers;

use App\Core\RequestOrder\RequestOrder;
use App\Exceptions\Access\NotAllowed;
use App\Exceptions\RequestOrder\{
    RequestOrderCookerNotSeted,
    RequestOrderItemNotStored,
    RequestOrderNotCreated,
    RequestOrderNotFinished,
    RequestOrderNotStarted,
    RequestOrderNotStored,
    RequestOrderNotUpdated,
};
use App\Exceptions\Table\TableNotFound;
use App\Helpers\ResponseHelper;
use App\Http\Requests\RequestOrderRequest;
use App\Repositories\{
    MenuRepository,
    Repository,
    RequestOrderItemRepository,
    RequestOrderRepository,
};
use App\Transformers\MenuTransformer;
use App\Types\RequestOrderStatusTypes;
use Illuminate\Http\JsonResponse;

class RequestOrderController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new RequestOrderRepository();
    }

    /**
     * @param RequestOrderRequest $request
     * @return JsonResponse
     * @throws RequestOrderItemNotStored
     * @throws RequestOrderNotCreated
     * @throws RequestOrderNotStored
     * @throws TableNotFound
     */
    public function store(RequestOrderRequest $request): JsonResponse
    {
        $request_order = new RequestOrder($request->user_id, $request->table_id, RequestOrderStatusTypes::PENDING);

        if (!$model = $this->repository->store($request_order))
            throw new RequestOrderNotCreated();

        (new RequestOrderItemRepository())->storeItems($model, $request->items);

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $menus = (new MenuRepository())->getAllWithItems()->toArray();

        return  ResponseHelper::results(['menus' => (new MenuTransformer())->index($menus)]);
    }

    /**
     * @param RequestOrderRequest $request
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     * @throws RequestOrderCookerNotSeted
     * @throws RequestOrderNotUpdated
     */
    public function setCooker(RequestOrderRequest $request, \App\Models\RequestOrder $requestOrder): JsonResponse
    {
        if (!$this->repository->setCooker($requestOrder, $request->user_id))
            throw new RequestOrderCookerNotSeted();

        return ResponseHelper::results(['id' => $requestOrder->id]);
    }

    /**
     * @param RequestOrderRequest $request
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     * @throws NotAllowed
     * @throws RequestOrderNotStarted
     * @throws RequestOrderNotUpdated
     */
    public function start(RequestOrderRequest $request, \App\Models\RequestOrder $requestOrder): JsonResponse
    {
        if (!$this->repository->start($requestOrder, $request->user_id))
            throw new RequestOrderNotStarted();

        return ResponseHelper::results(['id' => $requestOrder->id]);
    }

    /**
     * @param RequestOrderRequest $request
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     * @throws NotAllowed
     * @throws RequestOrderNotFinished
     * @throws RequestOrderNotUpdated
     */
    public function finish(RequestOrderRequest $request, \App\Models\RequestOrder $requestOrder): JsonResponse
    {
        if (!$this->repository->finish($requestOrder, $request->user_id))
            throw new RequestOrderNotFinished();

        return ResponseHelper::results(['id' => $requestOrder->id]);
    }
}
