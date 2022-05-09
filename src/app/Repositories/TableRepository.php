<?php

namespace App\Repositories;

use App\Models\Table;

class TableRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Table::class);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)Table::find($id);
    }
}
