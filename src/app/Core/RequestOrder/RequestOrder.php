<?php

namespace App\Core\RequestOrder;

use App\Core\Interfaces\RequestOrderInterface;

class RequestOrder implements RequestOrderInterface
{
    /**
     * @var int
     */
    private int $customerId;
    /**
     * @var int
     */
    private int $waiterId;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var int
     */
    private int $tableId;

    /**
     * @param int $customerId
     * @param int $waiterId
     * @param int $tableId
     * @param string $status
     */
    public function __construct(int $customerId, int $waiterId, int $tableId, string $status)
    {
        $this->customerId = $customerId;
        $this->waiterId = $waiterId;
        $this->status = $status;
        $this->tableId = $tableId;
    }

    /**
     * @return int
     */
    public function getWaiterId(): int
    {
        return $this->waiterId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTableId(): int
    {
        return $this->tableId;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}
