<?php

namespace App\Core\Table;

use App\Core\Interfaces\TableInterface;

class Table implements TableInterface
{
    /**
     * @var int
     */
    private int $number;
    /**
     * @var int
     */
    private int $quantitySeats;

    /**
     * @param int $number
     * @param int $quantity_seats
     */
    public function __construct(int $number, int $quantity_seats)
    {
        $this->number = $number;
        $this->quantitySeats = $quantity_seats;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getQuantitySeats(): int
    {
        return $this->quantitySeats;
    }
}
