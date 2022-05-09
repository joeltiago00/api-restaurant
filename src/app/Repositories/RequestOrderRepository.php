<?php

namespace App\Repositories;

use App\Core\Interfaces\RequestOrderInterface;
use App\Exceptions\Access\NotAllowed;
use App\Exceptions\RequestOrder\{RequestOrderNotGeted,
    RequestOrderNotStored,
    RequestOrderNotUpdated,
    RequestOrderPriceNotUpdated};
use App\Exceptions\Table\TableNotFound;
use App\Models\RequestOrder;
use App\Types\RequestOrderStatusTypes;
use Carbon\Carbon;

class RequestOrderRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(RequestOrder::class);
    }

    /**
     * @param RequestOrderInterface $order
     * @return RequestOrder
     * @throws RequestOrderNotStored
     * @throws TableNotFound
     */
    public function store(RequestOrderInterface $order): RequestOrder
    {
        if (!(new TableRepository())->existsById($order->getTableId()))
            throw new TableNotFound();

        try {
            return RequestOrder::create([
                'waiter_id' => $order->getWaiterId(),
                'status' => $order->getStatus(),
                'table_id' => $order->getTableId()
            ]);
        } catch (\Exception $e) {
            throw new RequestOrderNotStored($e);
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
     * @param string $term
     * @param int $pp
     * @return mixed
     * @throws RequestOrderNotGeted
     */
    public function getByUserAndTerm(int $user_id, string $term, int $pp)
    {
        try {
            return self::getModel()::with('items', 'waiter')
                ->when($term === RequestOrderStatusTypes::PENDING, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->when($term === RequestOrderStatusTypes::PREPARING, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->when($term === RequestOrderStatusTypes::FINISHED, function ($query) use ($term) {
                    return $query->where('request_orders.status', $term);
                })->where('waiter_id', $user_id)
                ->paginate($pp);
        } catch (\Exception $e) {
            throw new RequestOrderNotGeted($e);
        }
    }
}
