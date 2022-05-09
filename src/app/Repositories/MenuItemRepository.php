<?php

namespace App\Repositories;

use App\Models\MenuItem;

class MenuItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(MenuItem::class);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return (bool)self::getModel()::find($id);
    }


}
