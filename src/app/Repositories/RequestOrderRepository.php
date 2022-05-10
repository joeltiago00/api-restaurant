<?php

namespace App\Repositories;

use App\Core\Interfaces\RequestOrderInterface;
use App\Exceptions\Access\NotAllowed;
use App\Exceptions\Custumer\InvalidCustomer;
use App\Exceptions\General\NothingToUpdate;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Types\JobFunctionTypes;
use App\Exceptions\RequestOrder\{RequestOrderNotDeleted,
    RequestOrderNotGeted,
    RequestOrderNotStored,
    RequestOrderNotUpdated,
    RequestOrderPriceNotUpdated};
use App\Exceptions\Table\TableNotFound;
use App\Helpers\DateTimeHelper;
use App\Models\RequestOrder;
use App\Types\{
    RequestOrderFilterTypes,
    RequestOrderStatusTypes
};
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RequestOrderRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(RequestOrder::class);
    }

    /**
     * @param RequestOrderInterface $requestOrder
     * @return RequestOrder
     * @throws InvalidCustomer
     * @throws NotAllowed
     * @throws RequestOrderNotStored
     * @throws TableNotFound
     * @throws JobFunctionNotFound
     */
    public function store(RequestOrderInterface $requestOrder): RequestOrder
    {
        if (!(new TableRepository())->existsById($requestOrder->getTableId()))
            throw new TableNotFound();

        if (!(new CustomerRepository())->existsById($requestOrder->getCustomerId()))
            throw new InvalidCustomer();

        if (!(new UserRepository())->isWaiter($requestOrder->getWaiterId()))
            throw new NotAllowed();

        try {
            return RequestOrder::create([
                'waiter_id' => $requestOrder->getWaiterId(),
                'status' => $requestOrder->getStatus(),
                'table_id' => $requestOrder->getTableId(),
                'customer_id' => $requestOrder->getCustomerId(),
            ]);
        } catch (\Exception $e) {
            throw new RequestOrderNotStored($e);
        }
    }

    /**
     * @param RequestOrder $requestOrder
     * @param array $data
     * @return bool
     * @throws InvalidCustomer
     * @throws JobFunctionNotFound
     * @throws NotAllowed
     * @throws NothingToUpdate
     * @throws RequestOrderNotUpdated
     */
    public function update(RequestOrder $requestOrder, array $data): bool
    {
        if (empty($data))
            throw new NothingToUpdate();

        if (isset($data['waiter_id']) ?? !(new UserRepository())->isWaiter($data['waiter_id']))
            throw new NotAllowed();

        if (isset($data['cooker_id']) ?? !(new UserRepository())->isWaiter($data['cooker_id']))
            throw new NotAllowed();

        if (isset($data['customer_id']) ?? !(new CustomerRepository())->existsById($data['customer_id']))
            throw new InvalidCustomer();

        try {
            return $requestOrder->update([
                'waiter_id' => $data['customer_id'] ?? $requestOrder->customer_id,
                'cooker_id' => $data['cooker_id'] ?? $requestOrder->cooker_id,
                'table_id' => $data['table_id'] ?? $requestOrder->table_id,
                'customer_id' => $data['customer_id'] ?? $requestOrder->customer_id,
            ]);
        } catch (\Exception $e) {
            throw new RequestOrderNotUpdated($e);
        }
    }

    /**
     * @param RequestOrder $requestOrder
     * @return bool
     * @throws RequestOrderNotDeleted
     */
    public function delete(RequestOrder $requestOrder): bool
    {
        try {
            return (bool)$requestOrder->delete();
        } catch (\Exception $e) {
            throw new RequestOrderNotDeleted($e);
        }
    }

    /**
     * @param RequestOrder $order
     * @param float $price
     * @return bool
     * @throws RequestOrderPriceNotUpdated
     */
    public function setPrice(RequestOrder $order, float $price): bool
    {
        try {
            return $order->update(['price' => $price]);
        } catch (\Exception $e) {
            throw new RequestOrderPriceNotUpdated($e);
        }
    }

    /**
     * @param RequestOrder $order
     * @param int $user_id
     * @return bool
     * @throws RequestOrderNotUpdated
     */
    public function setCooker(RequestOrder $order, int $user_id): bool
    {
        try {
            return $order->update(['cooker_id' => $user_id]);
        } catch (\Exception $e) {
            throw new RequestOrderNotUpdated($e);
        }
    }

    /**
     * @param RequestOrder $order
     * @param int $cooker_id
     * @return bool
     * @throws NotAllowed
     * @throws RequestOrderNotUpdated
     */
    public function start(RequestOrder $order, int $cooker_id): bool
    {
        if (is_null($order->cooker_id))
            throw new NotAllowed();

        if ($cooker_id !== $order->cooker_id)
            throw new NotAllowed();

        try {
            return $order->update([
                'started_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'status' => RequestOrderStatusTypes::PREPARING
            ]);
        } catch (\Exception $e) {
            throw new RequestOrderNotUpdated($e);
        }
    }

    /**
     * @param RequestOrder $order
     * @param int $cooker_id
     * @return bool
     * @throws NotAllowed
     * @throws RequestOrderNotUpdated
     */
    public function finish(RequestOrder $order, int $cooker_id): bool
    {
        if (is_null($order->cooker_id))
            throw new NotAllowed();

        if ($cooker_id !== $order->cooker_id)
            throw new NotAllowed();

        if (is_null($order->started_at))
            throw new NotAllowed();

        try {
            return $order->update([
                'finished_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'status' => RequestOrderStatusTypes::FINISHED
            ]);
        } catch (\Exception $e) {
            throw new RequestOrderNotUpdated($e);
        }
    }

    /**
     * @param int $user_id
     * @param string $user_type
     * @param string $term
     * @param int $pp
     * @return LengthAwarePaginator
     * @throws RequestOrderNotGeted
     */
    public function getByUserAndTerm(int $user_id, string $user_type, string $term, int $pp): LengthAwarePaginator
    {
        try {
            return RequestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')
                ->when($term === RequestOrderStatusTypes::PENDING, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->when($term === RequestOrderStatusTypes::PREPARING, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->when($term === RequestOrderStatusTypes::FINISHED, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->when($user_type === JobFunctionTypes::WAITER, function ($query) use ($user_id) {
                     return $query->where('waiter_id', $user_id);
                })->when($user_type === JobFunctionTypes::COOKER, function ($query) use ($user_id) {
                    return $query->where('cooker_id', $user_id);
                })
                ->paginate($pp);
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }
    }

    /**
     * @param string $filter_type
     * @param $filter_value
     * @param string $term
     * @param int $pp
     * @return LengthAwarePaginator
     * @throws RequestOrderNotGeted
     */
    public function getByFilter(string $filter_type, $filter_value, string $term, int $pp): LengthAwarePaginator
    {
        try {
            return RequestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')
                ->when($filter_type === RequestOrderFilterTypes::DAY, function ($query) use ($filter_value) {
                    return $query->where('created_at', Carbon::parse($filter_value));
                })->when($filter_type === RequestOrderFilterTypes::WEEK, function ($query) {
                    return $query->where('created_at', '>=', DateTimeHelper::getFirstDayOfWeek())
                        ->where('created_at', '<=', DateTimeHelper::getLastDayOfWeek());
                })->when($filter_type === RequestOrderFilterTypes::MONTH, function ($query) {
                    return $query->where('created_at', '>=', Carbon::now()->startOfMonth())
                        ->where('created_at', '<=', Carbon::now()->endOfMonth());
                })->when($filter_type === RequestOrderFilterTypes::RANGE_DATE, function ($query) use ($filter_value) {
                    return $query->where('created_at', '>=', Carbon::parse($filter_value['begin']))
                        ->where('created_at', '<=', Carbon::parse($filter_value['finish']));
                })->when($filter_type === RequestOrderFilterTypes::BY_TABLE, function ($query) use ($filter_value) {
                    return $query->where('table_id', (int)$filter_value);
                })->when($filter_type === RequestOrderFilterTypes::BY_CLIENT, function ($query) use ($filter_value) {
                    return $query->where('costumer_id', (int)$filter_value);
                })->when($term === RequestOrderStatusTypes::PENDING, function ($query) {
                    return $query->where('status', RequestOrderStatusTypes::PENDING);
                })->when($term === RequestOrderStatusTypes::PREPARING, function ($query) {
                    return $query->where('status', RequestOrderStatusTypes::PREPARING);
                })->when($term === RequestOrderStatusTypes::FINISHED, function ($query) {
                    return $query->where('status', RequestOrderStatusTypes::FINISHED);
                })->paginate($pp);
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws RequestOrderNotGeted
     */
    public function getGreaterByCustomerId(int $id): array
    {
        try {
            return RequestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')
                ->where('customer_id', $id)
                ->orderBy('price', 'desc')
                ->first()->toArray();
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws RequestOrderNotGeted
     */
    public function getLessByCustomertId(int $id): array
    {
        try {
            return RequestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')
                ->where('customer_id', $id)
                ->orderBy('price', 'asc')
                ->first()->toArray();
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }

    }

    /**
     * @param int $id
     * @return array
     * @throws RequestOrderNotGeted
     */
    public function getFirstByCustomerId(int $id): array
    {
        try {
            return RequestOrder::with('items', 'customer', 'table', 'cooker', 'waiter')
                ->where('customer_id', $id)
                ->orderBy('created_at', 'asc')
                ->first()->toArray();
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }
    }
}
