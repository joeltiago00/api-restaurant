<?php

namespace App\Http\Controllers;

use App\Core\RequestOrder\RequestOrder;
use App\Exceptions\Access\NotAllowed;
use App\Exceptions\Custumer\InvalidCustomer;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Menu\MenuNotListed;
use App\Models\Customer;
use App\Transformers\RequestOrderTransformer;
use App\Types\PaginationValueTypes;
use App\Exceptions\RequestOrder\{RequestOrderCookerNotSeted,
    RequestOrderItemNotStored,
    RequestOrderNotChanged,
    RequestOrderNotCreated,
    RequestOrderNotDeleted,
    RequestOrderNotExcluded,
    RequestOrderNotFinished,
    RequestOrderNotGeted,
    RequestOrderNotListed,
    RequestOrderNotStarted,
    RequestOrderNotStored,
    RequestOrderNotUpdated};
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
     * @throws InvalidCustomer
     * @throws JobFunctionNotFound
     * @throws NotAllowed
     * @throws RequestOrderItemNotStored
     * @throws RequestOrderNotCreated
     * @throws RequestOrderNotStored
     * @throws TableNotFound
     */
    public function store(RequestOrderRequest $request): JsonResponse
    {
        $request_order = new RequestOrder($request->customer_id, $request->user_id, $request->table_id, RequestOrderStatusTypes::PENDING);

        if (!$model = $this->repository->store($request_order))
            throw new RequestOrderNotCreated();

        (new RequestOrderItemRepository())->storeItems($model, $request->items);

        return ResponseHelper::created(['id' => $model->id]);
    }

    /**
     * @param RequestOrderRequest $request
     * @return JsonResponse
     * @throws MenuNotListed
     */
    public function create(RequestOrderRequest $request): JsonResponse
    {
        if (!$menus = (new MenuRepository())->getAllWithItems($request->pp)->toArray())
            throw new MenuNotListed();

        return ResponseHelper::results([
            'menus' => (new MenuTransformer())->list($menus),
        ]);
    }

    /**
     * @param RequestOrderRequest $request
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     * @throws InvalidCustomer
     * @throws NotAllowed
     * @throws RequestOrderNotChanged
     * @throws RequestOrderNotUpdated
     * @throws NothingToUpdate
     * @throws JobFunctionNotFound
     */
    public function update(RequestOrderRequest $request, \App\Models\RequestOrder $requestOrder): JsonResponse
    {
        if (!$this->repository->update($requestOrder, $request->only(['waiter_id', 'cooker_id', 'table_id', 'customer_id'])))
            throw new RequestOrderNotChanged();

        return ResponseHelper::noContent();
    }

    /**
     * @param RequestOrderRequest $request
     * @return JsonResponse
     * @throws RequestOrderNotListed
     * @throws RequestOrderNotGeted
     */
    public function index(RequestOrderRequest $request): JsonResponse
    {
        if (
            !$request_orders = $this->repository->getByFilter(
                $request->filter_type,
                $request->filter_value, $request->term ?? 'all',
                $request->pp ?? PaginationValueTypes::PER_PAGE_DEFAULT)->toArray()
        )
            throw new RequestOrderNotListed();

        return ResponseHelper::results((new RequestOrderTransformer())->index($request_orders));
    }

    /**
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     */
    public function show(\App\Models\RequestOrder $requestOrder): JsonResponse
    {
        $requestOrder = $requestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')->get();

        return ResponseHelper::results(
            (new RequestOrderTransformer())->show($requestOrder->toArray())
        );
    }

    /**
     * @param \App\Models\RequestOrder $requestOrder
     * @return JsonResponse
     * @throws RequestOrderNotExcluded
     * @throws RequestOrderNotDeleted
     */
    public function delete(\App\Models\RequestOrder $requestOrder): JsonResponse
    {
        if (!$this->repository->delete($requestOrder))
            throw new RequestOrderNotExcluded();

        return ResponseHelper::noContent();
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

        return ResponseHelper::noContent();
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

        return ResponseHelper::noContent();
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

        return ResponseHelper::noContent();
    }

    /**
     * @param Customer $customer
     * @return JsonResponse
     * @throws RequestOrderNotGeted
     * @throws RequestOrderNotListed
     */
    public function getFirstGreaterLessByCustomer(Customer $customer): JsonResponse
    {
        if (!$greater = (new RequestOrderRepository())->getGreaterByCustomerId($customer->id))
            throw new RequestOrderNotListed();

        if (!$less = (new RequestOrderRepository())->getLessByCustomertId($customer->id))
            throw new RequestOrderNotListed();

        if (!$first = (new RequestOrderRepository())->getFirstByCustomerId($customer->id))
            throw new RequestOrderNotListed();

        return ResponseHelper::results((new RequestOrderTransformer())->firstGreaterLess([
            'first_request_order' => $first,
            'greater_request_order' => $greater,
            'less_request_order' => $less
        ]));
    }
}
